<?php

namespace Syw\Front\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

class AjaxAutocompleteJSONController extends BaseController
{

    /**
     * @Route("/shtumi_ajaxautocomplete")
     */
    public function getJSONAction()
    {
        $em      = $this->get('doctrine')->getManager();
        $request = $this->getRequest();

        $entities = $this->get('service_container')->getParameter('shtumi.autocomplete_entities');

        $entity_alias = $request->get('entity_alias');
        $entity_inf   = $entities[$entity_alias];

        if ($entity_inf['role'] !== 'IS_AUTHENTICATED_ANONYMOUSLY') {
            if (false === $this->get('security.context')->isGranted($entity_inf['role'])) {
                throw new AccessDeniedException();
            }
        }

        $letters = $request->get('letters');
        $maxRows = 100;

        switch ($entity_inf['search']) {
            case "begins_with":
                $like = $letters . '%';
                break;
            case "ends_with":
                $like = '%' . $letters;
                break;
            case "contains":
                $like = '%' . $letters . '%';
                break;
            default:
                throw new \Exception('Unexpected value of parameter "search"');
        }

        $property = $entity_inf['property'];

        if ($entity_inf['case_insensitive']) {
            $where_clause_lhs = 'WHERE LOWER(e.' . $property . ')';
            $where_clause_rhs = 'LIKE LOWER(:like)';
        } else {
            $where_clause_lhs = 'WHERE e.' . $property;
            $where_clause_rhs = 'LIKE :like';
        }

        if ($entity_inf['class'] == "SywFrontMainBundle:Cities") {
            $sql = 'SELECT e.id, e.isoCountryCode, e.region, e.latitude, e.longitude, e.' . $property . '
                 FROM ' . $entity_inf['class'] . ' e ' .
                $where_clause_lhs . ' ' . $where_clause_rhs . ' ' .
                'ORDER BY e.' . $property;
        } else {
            $sql = 'SELECT e.id, e.' . $property . '
                 FROM ' . $entity_inf['class'] . ' e ' .
                $where_clause_lhs . ' ' . $where_clause_rhs . ' ' .
                'ORDER BY e.' . $property;
        }

        $results = $em->createQuery($sql)
            ->setParameter('like', $like)
            ->setMaxResults($maxRows)
            ->getScalarResult();

        $res = array();
        foreach ($results as $r) {
            if ($entity_inf['class'] == "SywFrontMainBundle:Cities") {
                $res[] = $r[$entity_inf['property']] . "   (Country:" . $r['isoCountryCode'] . ", Region:" . $r['region'] . ", Lat:" . $r['latitude'] . ", Long:" . $r['longitude'] . ", ID:" . $r['id'] . ")";
            } else {
                $res[] = $r[$entity_inf['property']] . "   (ID:" . $r['id'] . ")";
            }
        }

        return new Response(json_encode($res));
    }
}
