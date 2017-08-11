<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntryTag
 *
 * @ORM\Table(name="ENTRY_TAG", indexes={@ORM\Index(name="fk_ENTRY_TAG_ENTRIES1_idx", columns={"entry_id"}), @ORM\Index(name="fk_ENTRY_TAG_TAGS1_idx", columns={"tag_id"})})
 * @ORM\Entity
 */
class EntryTag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="entry_id", type="integer", nullable=false)
     */
    private $entryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="tag_id", type="integer", nullable=false)
     */
    private $tagId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set entryId
     *
     * @param integer $entryId
     *
     * @return EntryTag
     */
    public function setEntryId($entryId)
    {
        $this->entryId = $entryId;

        return $this;
    }

    /**
     * Get entryId
     *
     * @return integer
     */
    public function getEntryId()
    {
        return $this->entryId;
    }

    /**
     * Set tagId
     *
     * @param integer $tagId
     *
     * @return EntryTag
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;

        return $this;
    }

    /**
     * Get tagId
     *
     * @return integer
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
