<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Faker\Factory;

class DeviceController extends Controller
{
    /**
     * The current Faker instance.
     *
     * @var Generator
     */
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/power",
     *     tags={"Stats"},
     *     summary="Сообщение от устройства о событии включения устройства",
     *     "operationId": "PowerPost",
     *     @OA\RequestBody(
     *        required = true,
     *        content = "application/json;charset=UTF-8",
     *        @OA\Schema($ref: "#/components/schemas/Power")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Подтверждение успешного сохранения",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/Power")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Возвращает описание ошибки запроса",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/Error")
     *     ),
     * )
     */
    public function power(): array
    {
        return [
            "GUID" => $this->faker->uuid,
            "DeviceID" => $this->faker->numberBetween(1, 100),
            'DeviceDTime' => $this->faker->date("Y-m-d\TH:i:sP"),
            "UserID" => $this->faker->numberBetween(1, 100),
            "power" => $this->faker->randomElement(["on", "off"])
        ];
    }

    /**
     * @OA\Post(
     *     path="/api/v1/mode",
     *     tags={"Stats"},
     *     summary="Сообщение о том, что пользователь выбрал определенный режим функционирования или изменил какие-либо настройки работы аппарата",
     *     "operationId": "ModeSelected",
     *     @OA\RequestBody(
     *        required = true,
     *        content = "application/json;charset=UTF-8",
     *        @OA\Schema($ref: "#/components/schemas/DeviceData")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Подтверждение успешной операции",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/DeviceData")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Возвращает описание ошибки запроса",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/Error")
     *     ),
     * )
     */
    public function mode(): array
    {
        return [
            "GUID" => $this->faker->uuid,
            "DeviceID" => $this->faker->numberBetween(1, 100),
            'DeviceDTime' => $this->faker->date("Y-m-d\TH:i:sP"),
            "UserID" => $this->faker->numberBetween(1, 100),
            "DeviceData" => $this->faker->shuffleArray(['старт', 'стоп'])
        ];
    }

    /**
     * @OA\Post(
     *     path="/api/v1/data",
     *     tags={"Stats"},
     *     summary="Отправка дсведений о наработке аппарата",
     *     "operationId": "SendData",
     *     @OA\RequestBody(
     *        required = true,
     *        content = "application/json;charset=UTF-8",
     *        @OA\Schema($ref: "#/components/schemas/DeviceData")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Подтверждение успешной операции",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/DeviceData")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Возвращает описание ошибки запроса",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/Error")
     *     ),
     * )
     */
    public function data(): array
    {
        return [
            "GUID" => $this->faker->uuid,
            "DeviceID" => $this->faker->numberBetween(1, 100),
            'DeviceDTime' => $this->faker->date("Y-m-d\TH:i:sP"),
            "UserID" => $this->faker->numberBetween(1, 100),
            "DeviceData" => $this->faker->shuffleArray(['старт', 'стоп'])
        ];
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/data/{guid}",
     *     tags={"Stats"},
     *     summary="Удаление события от устройства",
     *     "operationId": "DataDelete",
     *     @OA\Parameter(
     *         name="guid",
     *         in="path",
     *         required=true,
     *         description="guid раннее отправленного события",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Подтверждение успешного удаления",
     *         content = "application/json;charset=UTF-8",
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Возвращает описание ошибки запроса",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/Error")
     *     ),
     * )
     */
    public function delete(string $guid): object
    {
        return (object)[];
    }

    /**
     * @OA\Get(
     *     path="/api/v1/firmwares/{deviceID}",
     *     tags={"Device"},
     *     summary="Запрос списка доступных для устройства прошивок",
     *     "operationId": "FirmwaresList",
     *     @OA\Parameter(
     *         name="deviceID",
     *         in="path",
     *         required=true,
     *         description="Идентификатор устройства",
     *         example="42abcd2b-8b9c-4af9-88f7-0bc180cf74b4"
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Возвращается список доступных для устройства обновлений ПО",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema(type="array", items=$ref: "#/components/schemas/Firmware")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Возвращает описание ошибки запроса",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/Error")
     *     ),
     * )
     */
    public function firmwares(string $deviceID): array
    {
        $firmwares = [];

        for ($i = 0; $i <= $this->faker->numberBetween(1, 10); $i++) {
            $firmwares[] = [
                'firm_date' => $this->faker->date("Y-m-d\TH:i:sP"),
                'version' => $this->faker->numberBetween(1, 10) . '.' . $this->faker->numberBetween(1, 30) . '.' . $this->faker->numberBetween(1, 50),
                'firm_name' => $this->faker->randomElement(["UI", "Memory", "Driver"]),
                'link' => $this->faker->url,
                'id' => $deviceID
            ];
        }

        return $firmwares;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/status",
     *     tags={"Stats"},
     *     summary="Отправка данных о статусе работы аппарата (в реальной жизни скорее всего будет использоваться для пингов серевера)",
     *     "operationId": "SendStatus",
     *     @OA\RequestBody(
     *        required = true,
     *        content = "application/json;charset=UTF-8",
     *        @OA\Schema($ref: "#/components/schemas/DeviceData")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Подтверждение успешной операции",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/DeviceData")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Возвращает описание ошибки запроса",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/Error")
     *     ),
     * )
     */
    public function status(): array
    {
        return [
            "GUID" => $this->faker->uuid,
            "DeviceID" => $this->faker->numberBetween(1, 100),
            'DeviceDTime' => $this->faker->date("Y-m-d\TH:i:sP"),
            "UserID" => $this->faker->numberBetween(1, 100),
            "DeviceData" => $this->faker->shuffleArray(['старт', 'стоп'])
        ];
    }

    /**
     * @OA\Get(
     *     path="/api/v1/firmware/{id}",
     *     tags={"Device"},
     *     summary="Запрос новой версии, по номеру текущей версии",
     *     "operationId": "GetFirmaware",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID требуемой прошивки",
     *         example="25.1.16"
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Подтверждение успешного сохранения",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema(items=$ref: "#/components/schemas/Firmware")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Возвращает описание ошибки запроса",
     *         content = "application/json;charset=UTF-8",
     *         @OA\Schema($ref: "#/components/schemas/Error")
     *     ),
     * )
     */
    public function firmware(string $id): array
    {
        return [
            'firm_date' => $this->faker->date("Y-m-d\TH:i:sP"),
            'version' => $this->faker->numberBetween(1, 10) . '.' . $this->faker->numberBetween(1, 30) . '.' . $this->faker->numberBetween(1, 50),
            'firm_name' => $this->faker->randomElement(["UI", "Memory", "Driver"]),
            'link' => $this->faker->url,
            'id' => $id
        ];
    }
}






















