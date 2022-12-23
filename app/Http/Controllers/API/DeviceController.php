<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cycle;
use App\Models\Device;
use App\Models\DeviceData;
use App\Models\SensorData;
use App\Models\Stage;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use NunoMaduro\Collision\Adapters\Phpunit\State;

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
    public function power(Request $request): array|Response
    {
        $validator = Validator::make($request->all(),
            [
                'GUID' => 'required|string|max:36|unique:App\Models\DeviceData,guid',
                'DeviceID' => 'required|int',
                'DeviceDTime' => 'required|date_format:Y-m-d H:i:s|before_or_equal:' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+ 12 hours")),
                'UserID' => 'int',
                'power' => ['required', Rule::in(["on", "off"])]
            ],
            [
                'GUID.required' => 'GUID отсутствует, необходимо указать идентификатор запроса',
                'DeviceID.required' => 'DeviceID отсутствует, необходимо указать идентификатор устройства',
                'DeviceDTime.required' => 'DeviceDTime отсутствует, необходимо указать актуальное время на устройстве',
                'power.required' => 'Статус питания  отсутствует, необходимо заполнить поле DevicePower значением On или Off',
            ]
        );

        if ($validator->fails()) {
            return ['status' => 400, 'messages' => $validator->messages()];
        }

        $device = Device::find($request->get('DeviceID'));
        if (!$device) {
            return ['status' => 400, 'messages' => "Оборудование не идентифицировано"];
        }
        DeviceData::create([
            'guid' => $request->get('GUID'),
            'request_time' => date('Y-m-d H:i:s'),
            'ip' => $request->ip(),
            'device_id' => $request->get('DeviceID'),
            'device_d_time' => $request->get('DeviceDTime'),
            'type' => 'log',
            'device_data' => ["power: " . $request->get('power')],
        ]);

//        return [
//            "GUID" => $this->faker->uuid,
//            "DeviceID" => $this->faker->numberBetween(1, 100),
//            'DeviceDTime' => $this->faker->date("Y-m-d\TH:i:sP"),
//            "UserID" => $this->faker->numberBetween(1, 100),
//            "power" => $this->faker->randomElement(["on", "off"])
//        ];

        return [
            'status' => 200,
            'messages' => "Запрос успешно выполнен"
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
    public function mode(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'GUID' => 'required|string|max:36|unique:App\Models\DeviceData,guid',
            'DeviceID' => 'required|int',
            'DeviceDTime' => 'required|date_format:Y-m-d H:i:s|before_or_equal:' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+ 1 days")),
//            'UserID' => 'int',
            'DeviceData' => 'required|array',
        ]);

        if ($validator->fails()) {
            return [
                'validator' => $validator->messages()
            ];
        }

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
    public function data(Request $request): array|Response
    {
        $validator = Validator::make($request->all(),
            [
                'GUID' => 'required|string|max:36|unique:App\Models\DeviceData,guid',
                'DeviceID' => 'required|int',
                'SerialNum' => 'required|string|exists:App\Models\Device,serial_num',
                'CycleID' => 'int|exists:App\Models\Cycle,id',
                'DeviceDTime' => 'required|date_format:Y-m-d H:i:s|before_or_equal:' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+ 12 hours")),
                'UserID' => 'int',
                'DeviceData' => 'required|array',
            ],
            [
                'GUID.required' => 'GUID отсутствует, необходимо указать идентификатор запроса',
                'DeviceID.required' => 'DeviceID отсутствует, необходимо указать идентификатор устройства',
                'SerialNum.required' => 'SerialNum отсутствует, необходимо указать серийный номер устройства',
                'SerialNum.exists' => 'Устройство с таким серийным номером отсутствует в базе данных',
                'CycleID.int' => 'CycleID должно быть целочисленным значением',
                'CycleID.exists' => 'Цикл с таким идентификатором отсутствует в базе данных',
                'DeviceDTime.required' => 'DeviceDTime отсутствует, необходимо указать актуальное время на устройстве',
                'DeviceData.required' => 'DeviceData  отсутствует, необходимо заполнить массив данных от устройства',
            ]
        );

        if ($validator->fails()) {
            return ['status' => 400, 'messages' => $validator->messages()];
        }

        $device = Device::find($request->get('DeviceID'));
        if (!$device) {
            return ['status' => 400, 'messages' => "Оборудование не идентифицировано"];
        }

        DeviceData::create([
            'guid' => $request->get('GUID'),
            'request_time' => date('Y-m-d H:i:s'),
            'ip' => $request->ip(),
            'device_id' => $request->get('DeviceID'),
            'serial_num' => $request->get('SerialNum'),
            'cycle_id' => $request->get('CycleID') ?? null,
            'device_d_time' => $request->get('DeviceDTime'),
            'type' => 'sensor',
            'device_data' => $request->get('DeviceData'),
            'user_id' => $request->get('UserID'),
        ]);

        $data = $request->get('DeviceData');

        foreach ($data as $item) {
            SensorData::create([
                'device_id' => $request->get('DeviceID'),
                'cycle_id' => $request->get('CycleID') ?? null,
                'row_id' => $item[0],
                'date_time' => "2022-12-20 08:20:51", // $item[1],
                'row_data' => array_slice($item, 2),
            ]);
        }

//        return [
//            "GUID" => $this->faker->uuid,
//            "DeviceID" => $this->faker->numberBetween(1, 100),
//            'DeviceDTime' => $this->faker->date("Y-m-d\TH:i:sP"),
//            "UserID" => $this->faker->numberBetween(1, 100),
//            "DeviceData" => $this->faker->shuffleArray(['старт', 'стоп'])
//        ];

        return [
            'status' => 200,
            'messages' => "Запрос успешно выполнен"
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
    public function status(Request $request): array|Response
    {
        $validator = Validator::make($request->all(),
            [
                'GUID' => 'required|string|max:36|unique:App\Models\DeviceData,guid',
                'DeviceID' => 'required|int',
                'SerialNum' => 'required|string|exists:App\Models\Device,serial_num',
                'CycleID' => 'int|unique:App\Models\Cycle,id',
                'DeviceDTime' => 'required|date_format:Y-m-d H:i:s|before_or_equal:' . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . "+ 12 hours")),
                'UserID' => 'nullable|int',
                'DeviceData' => 'required|array',
            ],
            [
                'GUID.required' => 'GUID отсутствует, необходимо указать идентификатор запроса',
                'DeviceID.required' => 'DeviceID отсутствует, необходимо указать идентификатор устройства',
                'SerialNum.required' => 'SerialNum отсутствует, необходимо указать серийный номер устройства',
                'SerialNum.exists' => 'Устройство с таким серийным номером отсутствует в базе данных',
                'CycleID.integer' => 'CycleID должно быть целочисленным значением',
                'CycleID.unique' => 'Цикл с таким идентификатором уже создан в БД по этому устройству. Для записи нового цикла с таким же идентификатором сначала удалите старую запись командой Delete Data',
                'DeviceDTime.required' => 'DeviceDTime отсутствует, необходимо указать актуальное время на устройстве',
                'DeviceData.required' => 'DeviceData  отсутствует, необходимо заполнить массив данных от устройства',
            ]
        );

        if ($validator->fails()) {
            return ['status' => 400, 'messages' => $validator->messages()];
        }

        $device = Device::find($request->get('DeviceID'));
        if (!$device) {
            return ['status' => 400, 'messages' => "Оборудование не идентифицировано"];
        }

        DeviceData::create([
            'guid' => $request->get('GUID'),
            'request_time' => date('Y-m-d H:i:s'),
            'ip' => $request->ip(),
            'device_id' => $request->get('DeviceID'),
            'serial_num' => $request->get('SerialNum'),
            'cycle_id' => $request->get('CycleID') ?? null,
            'device_d_time' => $request->get('DeviceDTime'),
            'type' => 'log',
            'device_data' => $request->get('DeviceData'),
            'user_id' => $request->get('UserID'),
        ]);

        $number = '';
        $stages = [];
        $stageCurrentIndex = 0;
        $stageState = false;
        $stageEndedIndex = -10;

        foreach ($request->get('DeviceData') as $key => $row) {
            if (strpos($row, 'Длинный цикл') !== false) {
                $x = strpos($row, "Длинный цикл");
                $number = mb_substr($row, $x + 13);
                preg_match_all('/\[(.*?)\]/', $row, $matches_ended_at);
                $cycleStartedAt = date("Y:m:d") . " " . $matches_ended_at[1][0];
            } else if (mb_strpos($row, '--- Стадия') !== false && (mb_strpos($row, 'завершена ---') === false && mb_strpos($row, 'Завершена ---') === false)) {
                preg_match_all('/--- Стадия (.*?) ---/', $row, $matches_name);
                preg_match_all('/\[(.*?)\]/', $row, $matches_started_at);
                $stages[] = [
                    'number' => count($stages) + 1,
                    'name' => trim($matches_name[1][0], '"'),
                    'started_at' => date("Y:m:d") . " " . $matches_started_at[1][0],
//                  'started_at' => $row,
                ];
                $stageCurrentIndex = count($stages) - 1;
                $stageState = true;
            } else if (mb_strpos($row, '--- Стадия') !== false && (mb_strpos($row, 'завершена ---') !== false || mb_strpos($row, 'Завершена ---') !== false)) {
                preg_match_all('/\[(.*?)\]/', $row, $matches_ended_at);
                $stageEndedIndex = $key;
//                $stages[$stageCurrentIndex]['ended_at'] = $row;
                $stages[$stageCurrentIndex]['ended_at'] = date("Y:m:d") . " " . $matches_ended_at[1][0];
            } else if ($stageEndedIndex === $key - 1) {
                $stageEndedIndex = -10;
                $stageState = false;
            } else if (count($stages) > 0 && $stageState) {
                $stages[$stageCurrentIndex]['data'][] = $row;
            } else if (strpos($row, 'Cycle end') !== false) {
                preg_match_all('/\[(.*?)\]/', $row, $matches_ended_at);
                $cycleEndedAt = date("Y:m:d") . " " . $matches_ended_at[1][0];
            } else if (strpos($row, 'Общее время работы: ') !== false) {
                preg_match_all('/Общее время работы: (.*?) cек./', $row, $matches_duration);
                $cycleDuration = $matches_duration[1][0];
            }
        }

        $cycle = Cycle::create([
            'id' => $request->get('CycleID'),
            'number' => $number,
            'started_at' => $cycleStartedAt,
            'ended_at' => $cycleEndedAt ?? null,
            'duration' => $cycleDuration ?? null,
            'status' => 1,
        ]);

        foreach ($stages as $stage) {
            Stage::create(array_merge($stage, ['cycle_id' => $cycle->id]));
        }

//        return [
//            "GUID" => $this->faker->uuid,
//            "DeviceID" => $this->faker->numberBetween(1, 100),
//            'DeviceDTime' => $this->faker->date("Y-m-d\TH:i:sP"),
//            "UserID" => $this->faker->numberBetween(1, 100),
//            "DeviceData" => $this->faker->shuffleArray(['старт', 'стоп'])
//        ];

        return [
            'status' => 200,
            'messages' => "Запрос успешно выполнен"
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






















