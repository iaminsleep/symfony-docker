<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['dev' => true, 'test' => true],
    // Для использования фиктсур в тестах. Фикстуры необходимы для заполнения базы данных фейковыми данными.
    Liip\TestFixturesBundle\LiipTestFixturesBundle::class => ['dev' => true, 'test' => true],
    // Для оборачивания тестов в транзакции, чтобы они не влияли на базу данных. К тому же, тесты проходят в 2-3 раза быстрее.
    DAMA\DoctrineTestBundle\DAMADoctrineTestBundle::class => ['dev' => true, 'test' => true],
];
