<?php
class Animal
{
    public function renderAnimalName(AnimalInterface $animalInterface)
    {
        return $animalInterface->getName();
    }
}

interface AnimalInterface
{
    public function getName(): void;
}

class Dog implements AnimalInterface
{
    private string $name = 'dog01';

    public function getName(): void
    {
        echo $this->name;
    }

}

class Cat implements AnimalInterface
{
    private string $name = 'cat01';

    public function getName(): void
    {
        echo $this->name;
    }
}

$dog = new Dog();
$cat = new Cat();
$animal = new Animal();
return $animal->renderAnimalName($cat);
