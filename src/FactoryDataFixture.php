<?php

declare(strict_types=1);

namespace FG\Bundle\FactoryBundle;

use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixturesBundle;
use Doctrine\Persistence\ObjectManager;
use FG\Bundle\FactoryBundle\Support\Strings\Str;

abstract class FactoryDataFixture extends DoctrineFixturesBundle
{
    /**
     * @var object
     */
    private $populatedEntity;

    public function __construct(array $data = [])
    {
        $faker = \Faker\Factory::create();

        $mergedData = array_merge(
            $this->factory($faker),
            $data
            );

        $this->populatedEntity = $this->createEntityFrom($mergedData);
        $this->beforeSaving($this->getEntity(), $faker);
    }

    /**
     * Generates a faker data for entity.
     *
     * @param \Faker\Generator $faker
     * @return array
     */
    abstract protected function factory(\Faker\Generator $faker): array;

    abstract protected function entity(): string;

    /**
     * Uses to handle the entity before saving to database.
     *
     * @param \App\Entity\object|object $entity
     * @param \Faker\Generator $faker
     */
    protected function beforeSaving($entity, \Faker\Generator $faker):void
    {}

    /**
     * Returns the populated entity after seeded from faker.
     *
     * @return \App\Entity\object|object
     */
    protected function getEntity()
    {
        return $this->populatedEntity;
    }

    public function load(ObjectManager $manager)
    {
        $manager->persist($this->populatedEntity);
        $manager->flush();
    }

    private function createEntityFrom(array $data)
    {
        $class = $this->entity();
        $entity = new $class;

        foreach ($data as $key => $value) {
            $method = 'set'.Str::make($key)->studly();
            if (method_exists($entity,$method)){
                $entity->$method($value);
            }
        }

        return $entity;
    }
}