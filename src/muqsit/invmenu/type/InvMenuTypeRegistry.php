<?php

declare(strict_types=1);

namespace muqsit\invmenu\type;

use muqsit\invmenu\type\util\InvMenuTypeBuilders;
use pocketmine\block\VanillaBlocks;
use pocketmine\network\mcpe\protocol\types\inventory\WindowTypes;

final class InvMenuTypeRegistry{

	/** @var array<string, InvMenuType> */
	private array $types = [];

	/** @var array<int, string> */
	private array $identifiers = [];

	public function __construct(){
		$this->register(InvMenuTypeIds::TYPE_CHEST, InvMenuTypeBuilders::BLOCK_ACTOR_FIXED()
			->setBlock(VanillaBlocks::CHEST())
			->setSize(27)
			->setBlockActorId("Chest")
		->build());

		$this->register(InvMenuTypeIds::TYPE_DOUBLE_CHEST, InvMenuTypeBuilders::DOUBLE_PAIRABLE_BLOCK_ACTOR_FIXED()
			->setBlock(VanillaBlocks::CHEST())
			->setSize(54)
			->setBlockActorId("Chest")
			->setAnimationDuration(1)
		->build());

		$this->register(InvMenuTypeIds::TYPE_HOPPER, InvMenuTypeBuilders::BLOCK_ACTOR_FIXED()
			->setBlock(VanillaBlocks::HOPPER())
			->setSize(5)
			->setBlockActorId("Hopper")
			->setNetworkWindowType(WindowTypes::HOPPER)
		->build());

        $this->register(InvMenuTypeIds::TYPE_ENDER_CHEST, InvMenuTypeBuilders::BLOCK_ACTOR_FIXED()
            ->setBlock(VanillaBlocks::ENDER_CHEST())
            ->setSize(27)
            ->setBlockActorId("EnderChest")
            ->build());

        $this->register(InvMenuTypeIds::TYPE_SHULKER, InvMenuTypeBuilders::BLOCK_FIXED()
            ->setBlock(VanillaBlocks::SHULKER_BOX())
            ->setSize(27)
            ->build());

        $this->register(InvMenuTypeIds::TYPE_CRAFTING_TABLE, InvMenuTypeBuilders::BLOCK_FIXED()
            ->setBlock(VanillaBlocks::CRAFTING_TABLE())
            ->setSize(9)
            ->build());
	}

	public function register(string $identifier, InvMenuType $type) : void{
		if(isset($this->types[$identifier])){
			unset($this->identifiers[spl_object_id($this->types[$identifier])], $this->types[$identifier]);
		}

		$this->types[$identifier] = $type;
		$this->identifiers[spl_object_id($type)] = $identifier;
	}

	public function exists(string $identifier) : bool{
		return isset($this->types[$identifier]);
	}

	public function get(string $identifier) : InvMenuType{
		return $this->types[$identifier];
	}

	public function getIdentifier(InvMenuType $type) : string{
		return $this->identifiers[spl_object_id($type)];
	}

	public function getOrNull(string $identifier) : ?InvMenuType{
		return $this->types[$identifier] ?? null;
	}

	/**
	 * @return array<string, InvMenuType>
	 */
	public function getAll() : array{
		return $this->types;
	}
}