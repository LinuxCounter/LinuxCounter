<?php

namespace Asm\TranslationLoaderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TranslationHistory
 *
 * @ORM\Table(name="translation_history", indexes={@ORM\Index(name="search_idx", columns={"trans_key", "trans_locale", "message_domain"})})
 * @ORM\Entity
 */
class TranslationHistory
{
    /**
     * @var string
     *
     * @ORM\Column(name="trans_key", type="string", length=255, nullable=false)
     */
    private $transKey;

    /**
     * @var string
     *
     * @ORM\Column(name="trans_locale", type="string", length=5, nullable=false)
     */
    private $transLocale;

    /**
     * @var string
     *
     * @ORM\Column(name="message_domain", type="string", length=255, nullable=false)
     */
    private $messageDomain;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=255)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_action", type="string", length=10, nullable=false)
     */
    private $userAction;

    /**
     * @var string
     *
     * @ORM\Column(name="translation", type="text")
     */
    private $translation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_change", type="datetime", nullable=false)
     */
    private $dateOfChange;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
}
