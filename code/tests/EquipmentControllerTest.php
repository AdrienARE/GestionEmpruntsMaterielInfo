<?php


require_once(__DIR__ ."/../Controller/EquipmentController.php");
require_once(__DIR__ ."/../Controller/DataBase.php");
require_once(__DIR__ ."/../Model/Equipment.php");


use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

/**
 * Class EquipmentControllerTest
 * Unitary and integration test for class EquipmentController
 * @covers EquipmentController
 * @author Alhabaj Mahmod, Anica Sean, Belda Tom, Ingarao Adrien, Maggouh Naoufal, Ung Alexandre
 */
final class EquipmentControllerTest extends TestCase
{

    /*************************************************************************TEST UNITAIRES*************************************************************************************************/
    /****************************************************************************************************************************************************************************************/


    /**
     * Test valid modification for object equipment
     * @covers       EquipmentController::modifyEquipment
     * @dataProvider providerValidModifyEquipment
     * @param $ref_equip
     * @param $type_equip
     * @param $name_equip
     * @param $brand_equip
     * @param $version_equip
     * @param $quantity_equ
     * @throws Exception
     *
     */
    public function testValidModifyEquipment($ref_equip, $type_equip, $name_equip, $brand_equip, $version_equip, $quantity_equip): void
    {
        $equipmentController = new EquipmentController();
        $equipmentToTest = new Equipment("XX000","testType","testName","testBrand","0.0");

        $dbMock = $this->createMock(EquipmentDAO::class);

        $dbMock->method('isRefEquipUsed')
            ->willReturn(false);
        $dbMock->method('howMuchAvailable')
            ->willReturn(10);
        $dbMock->method('updateDeviceCount')
            ->willReturn(true);
        $dbMock->method('modifyEquipment')
            ->willReturn(true);

        $equipmentController->setEquipment($equipmentToTest);
        $equipmentController->setEquipmentDAO($dbMock);

        $equipmentController->modifyEquipment($ref_equip, $type_equip, $name_equip, $brand_equip, $version_equip, $quantity_equip);

        assertSame($ref_equip,$equipmentController->getEquipment()->getRefEquip());
        assertSame($type_equip,$equipmentController->getEquipment()->getTypeEquip());
        assertSame($name_equip,$equipmentController->getEquipment()->getNameEquip());
        assertSame($brand_equip,$equipmentController->getEquipment()->getBrandEquip());
        assertSame($version_equip,$equipmentController->getEquipment()->getVersionEquip());
    }

    /**
     * Test invalid modification for object equipment
     * @covers       EquipmentController::modifyEquipment
     * @dataProvider providerBadValuesModifyEquipment
     * @param $ref_equip
     * @param $type_equip
     * @param $name_equip
     * @param $brand_equip
     * @param $version_equip
     * @param $quantity_equip
     * @throws Exception
     *
     */
    public function testBadValuesModifyEquipment($ref_equip, $type_equip, $name_equip, $brand_equip, $version_equip, $quantity_equip): void
    {
        $equipmentController = new EquipmentController();
        $equipmentToTest = new Equipment("XX000","testType","testName","testBrand","0.0");

        $dbMock = $this->createMock(EquipmentDAO::class);

        $dbMock->method('isRefEquipUsed')
            ->willReturn(false);
        $dbMock->method('howMuchAvailable')
            ->willReturn(10);
        $dbMock->method('updateDeviceCount')
            ->willReturn(true);
        $dbMock->method('modifyEquipment')
            ->willReturn(true);

        $equipmentController->setEquipment($equipmentToTest);
        $equipmentController->setEquipmentDAO($dbMock);

        $this->expectException(Exception::class);
        $equipmentController->modifyEquipment($ref_equip, $type_equip, $name_equip, $brand_equip, $version_equip, $quantity_equip);

        assertSame("XX000",$equipmentController->getEquipment()->getRefEquip());
        assertSame("testType",$equipmentController->getEquipment()->getTypeEquip());
        assertSame("testName",$equipmentController->getEquipment()->getNameEquip());
        assertSame("testBrand",$equipmentController->getEquipment()->getBrandEquip());
        assertSame("0.0",$equipmentController->getEquipment()->getVersionEquip());
    }

    /**
     * Test valid creation of object Equipment
     * @covers       EquipmentController::createNewEquipment
     * @dataProvider providerValidCreateNewEquipment
     * @param $ref_equip
     * @param $type_equip
     * @param $name_equip
     * @param $brand_equip
     * @param $version_equip
     * @param $quantity_equip
     * @throws Excep
     */
    public function testValidCreateNewEquipment($ref_equip, $type_equip, $name_equip, $brand_equip, $version_equip, $quantity_equip): void
    {
        $equipmentController = new EquipmentController();
        $equipmentToTest = new Equipment($ref_equip,$type_equip,$name_equip,$brand_equip,$version_equip);

        $dbMock = $this->createMock(EquipmentDAO::class);

        $dbMock->method('isNewRefEquipUsed')
            ->willReturn(false);
        $dbMock->method('createEquipment')
            ->willReturn(true);

        $equipmentController->setEquipment($equipmentToTest);
        $equipmentController->setEquipmentDAO($dbMock);

        self::assertTrue($equipmentController->createNewEquipment($quantity_equip));
    }

    /**
     * Test invalid creation for object Equipment
     * @covers       EquipmentController::createNewEquipment
     * @dataProvider providerBadValuesCreateNewEquipment
     * @param $ref_equip
     * @param $type_equip
     * @param $name_equip
     * @param $brand_equip
     * @param $version_equip
     * @param $quantity_equip
     * @throws Exception
     * @throws TypeError
     *
     */
    public function testBadValuesCreateNewEquipment($ref_equip, $type_equip, $name_equip, $brand_equip, $version_equip, $quantity_equip): void
    {
        $equipmentController = new EquipmentController();
        $equipmentToTest = new Equipment($ref_equip,$type_equip,$name_equip,$brand_equip,$version_equip);
        $equipmentController->setEquipment($equipmentToTest);

        $dbMock = $this->createMock(EquipmentDAO::class);

        $dbMock->method('isNewRefEquipUsed')
            ->willReturn(false);
        $dbMock->method('createEquipment')
            ->willReturn(true);
        $equipmentController->setEquipmentDAO($dbMock);

        $this->expectException(Exception::class);

        $result = $equipmentController->createNewEquipment($quantity_equip);

        self::assertTrue($result);
    }

    /*******************************************************************************TEST D'INTEGRATION***************************************************************************************/
    /****************************************************************************************************************************************************************************************/

    /** Executes before the first test */
    public static function setUpBeforeClass(): void
    {
        $edao = new EquipmentDAO();

        $edao->createEquipment("XX001", "TypeEquip", "BrandEquip", "NameEquip", "VersionEquip", 1);
    }

    /** Executes after the last test */
    public static function tearDownAfterClass(): void
    {
        $dataBase = new DataBase();
        $dataBase->purgeDatabase();
    }

    /**
     * Test creation for object Equipment
     */
    public function testCreateEquipment(): void
    {
        $equipment1 = new Equipment("XX000", "TypeTest", "NameTest", "BrandTest", "VersionTest");

        $ec = new EquipmentController();

        $ec->loadEquipmentFromObject($equipment1);

        $ec->createNewEquipment(3);

        $ec->loadEquipmentFromDDB("XX000");

        $this->assertEquals(3, $ec->getEquipmentDAO()->howMuchTotal("XX000"));

        $equipment2 = $ec->getEquipment();

        $this->assertEquals($equipment1->getRefEquip(), $equipment2->getRefEquip());
        $this->assertEquals($equipment1->getBrandEquip(), $equipment2->getBrandEquip());
        $this->assertEquals($equipment1->getVersionEquip(), $equipment2->getVersionEquip());
        $this->assertEquals($equipment1->getTypeEquip(), $equipment2->getTypeEquip());
        $this->assertEquals($equipment1->getNameEquip(), $equipment2->getNameEquip());

    }

    /** Test invalid creation for object Equipment with already existing ref in db  */
    public function testCreateEquipmentDoublon(): void
    {
        $equipment = new Equipment("XX002", "TypeTest", "NameTest", "BrandTest", "VersionTest");

        $ec = new EquipmentController();

        $ec->loadEquipmentFromObject($equipment);

        $ec->createNewEquipment(3);

        $this->expectException(Exception::class);

        $ec->createNewEquipment(1);

    }

     /** Test modification of an Equipment */
    public function testModifyEquipment(): void
    {
        $ec = new EquipmentController();

        $ec->loadEquipmentFromDDB("XX001");

        $ec->modifyEquipment("XX001", "TypeTest1", "NameTest1", "BrandTest1", "VersionTest1", 1);

        $ec->loadEquipmentFromDDB("XX001");

        $equipment = $ec->getEquipment();

        $this->assertEquals($equipment->getRefEquip(), "XX001");
        $this->assertEquals($equipment->getBrandEquip(), "BrandTest1");
        $this->assertEquals($equipment->getVersionEquip(), "VersionTest1");
        $this->assertEquals($equipment->getTypeEquip(), "TypeTest1");
        $this->assertEquals($equipment->getNameEquip(), "NameTest1");

    }
    /** Test invalid modification of an Equipment with already existing ref in db  */
    public function testModifyEquipmentDoublon(): void
    {
        $ec = new EquipmentController();

        $equipment1 = new Equipment("XX004", "TypeTest", "NameTest", "BrandTest", "VersionTest");

        $ec->loadEquipmentFromObject($equipment1);

        $ec->createNewEquipment(1);

        $equipment2 = new Equipment("XX003", "TypeTest", "NameTest", "BrandTest", "VersionTest");

        $ec->loadEquipmentFromObject($equipment2);

        $ec->createNewEquipment(1);

        $this->expectException(Exception::class);

        $ec->modifyEquipment("XX004", "TypeTest1", "NameTest1", "BrandTest1", "VersionTest1", 1);

    }

    /** Test modification of the quantity of an Equipment  */
    public function testModifyEquipmentDeviceNumber(): void
    {
        $ec = new EquipmentController();

        $equipment = new Equipment("XX006", "TypeTest", "NameTest", "BrandTest", "VersionTest");

        $ec->loadEquipmentFromObject($equipment);

        $ec->createNewEquipment(3);

        $this->assertEquals(3, $ec->getEquipmentDAO()->howMuchTotal("XX006"));

        $ec->modifyEquipment("XX006", "TypeTest", "NameTest", "BrandTest", "VersionTest", 5);

        $this->assertEquals(5, $ec->getEquipmentDAO()->howMuchTotal("XX006"));

        $ec->modifyEquipment("XX006", "TypeTest", "NameTest", "BrandTest", "VersionTest", 1);

        $this->assertEquals(1, $ec->getEquipmentDAO()->howMuchTotal("XX006"));

        $this->expectException(Exception::class);

        $ec->modifyEquipment("XX006", "TypeTest", "NameTest", "BrandTest", "VersionTest", -1);
    }



    /////////////////////////////////////////////////////////////////////////////////////
    /// PROVIDER ////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////

    public function providerValidModifyEquipment(): array
    {
        return [
            ["AN999","Smartphone","Iphone9","apple","12.0",5],
            ["XX150","Tablette","Galaxy_Note_Pad_2","Samsung","9.0",10],
            ["AP490","Smartphone","SamsungS10","Samsung","1.0",14],
            ["XX640","Television","Crystal_UHD_75TU8075_SMART_TV","SAMSUNG","1.0",1]
        ];
    }

    public function providerBadValuesModifyEquipment(): array
    {
        return [
            ["","Smartphone","Iphone9","Apple","12.0",5],
            ["XX150","Täblette","Galaxy,NotePad2","Samsung","9.0",10],
            ["AQ490","Smartphone","BlackBerry","","1.0",14],
            ["XX6400","Television","Crystal_UHD_75TU8075_SMART_TV","SAMSUNG","1.0",1],
            ["XX550","Televisionnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn","Mapple","Philips","1.0",8],
            ["XX860","testType","","Philips","17.0",1],
            ["XX220","Television","LG415485","6+59+","1",1]
        ];
    }

    public function providerValidCreateNewEquipment(): array
    {
        return [
            ["AN999","Smartphone","Iphone9","apple","12.0",5],
            ["XX150","Tablette","Galaxy_Note_Pad_2","Samsung","9.0",10],
            ["AP490","Smartphone","SamsungS10","Samsung","1.0",14],
            ["XX640","Television","Crystal_UHD_75TU8075_SMART_TV","SAMSUNG","1.0",1]
            //["XX640","Television","Crystal_UHD_75TU8075_SMART_TV","SAMSUNG","1.0","1"] passe car php convertit les variables passées en parametre
        ];
    }

    public function providerBadValuesCreateNewEquipment(): array
    {
        return [
            ["AN999","Smartphone","Iphone9","apple","12.0",-4],
            ["XX150","Tablette","Galaxy_Note_Pad_2","Samsûng","9.0",10],
            ["AP790","Smartphone","Sams/ungS10","Samsung","1.0",14],
            ["AN999","Sm@rtphone","Iphone_5S","Apple","12.0",5],
            ["XX860","Television","Phil752","Ph£lips","17.0",140],
            ["AN419","Smartphone","Iphone9","Ap<<ple","12.0",5],
        ];
    }





}

