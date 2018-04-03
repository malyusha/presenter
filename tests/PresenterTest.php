<?php

use Malyusha\Presenter\Exceptions\PresenterException;

class PresenterTest extends PHPUnit\Framework\TestCase
{
    /**
     * @covers PresentableTrait::present()
     */
    public function test_entity_creates_presenter_when_using_trait()
    {
        $presenter = (new TestEntity)->present();
        $this->assertInstanceOf(TestPresenter::class, $presenter);
    }

    /**
     * @covers PresentableTrait::present()
     */
    public function test_entity_caches_presenter()
    {
        $entity = new TestEntity;
        $presenterOne = $entity->present();
        $this->assertSame($presenterOne, $entity->present(), 'Presenters returned by TestEntity are not the same objects. It\'s not cached.');
    }

    /**
     * @covers PresentableTrait::present()
     */
    public function test_it_throws_exception_when_no_presenter_property_defined()
    {
        $this->expectException(PresenterException::class);
        $this->getErrorEntity()->present();
    }

    /**
     * @covers PresentableTrait::present()
     */
    public function test_it_throws_exception_when_presenter_does_not_exist()
    {
        $entity = $this->getErrorEntity();
        $entity->presenter = 'NonExistingPresenter';
        $this->expectException(PresenterException::class);

        $entity->present();
    }

    public function test_presenter_uses_magic_methods()
    {
        $entity = new TestEntity;

        $this->assertEquals($entity->attribute, $entity->present()->attribute);
        $this->assertEquals($entity->getClassName(), $entity->present()->getClassName());
    }

    public function test_presenter_caches_methods_results()
    {
        $presenter = (new TestEntity)->present();
        $presenter2 = (new TestEntity)->present();
        $randomResult = $presenter->methodWithRandomResult();

        for ($i = 0; $i < 10; $i++) {
            $this->assertEquals($randomResult, $presenter->methodWithRandomResult());
        }

        $this->assertNotEquals($randomResult, $presenter2->methodWithRandomResult());
    }

    protected function getErrorEntity()
    {
        return new class
        {
            use \Malyusha\Presenter\PresentableTrait;
        };
    }
}

class TestPresenter extends \Malyusha\Presenter\Presenter
{
}

class TestEntity
{
    use \Malyusha\Presenter\PresentableTrait;

    /**
     * @var array[int]bool Array of results, that were returned from methodWithRandomResult.
     */
    protected static $randomCalls = [];

    protected $presenter = TestPresenter::class;

    public $attribute = 'Hello from test';

    public function methodWithRandomResult(): int
    {
        do {
            $result = random_int(0, 50000);
            static::$randomCalls[$result] = true;
        } while (!isset(static::$randomCalls[$result]));

        return $result;
    }

    public function getCount(): int
    {
        return count(static::$randomCalls);
    }

    public function getClassName(): string
    {
        return static::class;
    }
}