<?php

namespace Users;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\BaseEntity;
use Nette\Utils\Strings;

/**
 * @ORM\Entity
 *
 * @method getEmail
 */
class User extends BaseEntity
{

	use Identifier;

	/**
	 * @ORM\Column(type="string", options={"comment":"User's email"})
	 * @var string
	 */
	private $email;

	/**
	 * @ORM\ManyToMany(targetEntity="\Users\Role", cascade={"persist"})
	 * @ORM\JoinTable(
	 *        joinColumns={@ORM\JoinColumn(name="user_id", onDelete="cascade")},
	 *        inverseJoinColumns={@ORM\JoinColumn(name="role")}
	 * )
	 * @var \Users\Role[]|ArrayCollection
	 */
	protected $roles;

	/**
	 * @ORM\Column(type="datetime", options={"comment":"Date of user account creation"})
	 * @var \DateTime
	 */
	private $createdAt;

	public function __construct($email)
	{
		$this->setEmail($email);
		$this->roles = new ArrayCollection();
		$this->createdAt = new \DateTime();
	}

	protected function setEmail($email)
	{
		$this->email = Strings::lower($email);
		return $this;
	}

}
