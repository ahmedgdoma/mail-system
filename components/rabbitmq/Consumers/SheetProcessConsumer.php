<?php

namespace components\rabbitmq\Consumers;

use components\services\SheetService;
use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;

class SheetProcessConsumer implements ConsumerInterface
{
    /**
     * @param AMQPMessage $msg
     * @return bool
     * @throws Exception
     */
    public function execute(AMQPMessage $msg): bool
    {
        $msg = json_decode($msg->body);
        $body = $msg->body;
        $subject = $msg->subject;
        $fileName = $msg->fileName;
        $data = SheetService::read($msg->fileName);
        foreach ($data as $key => $value) {
            if ($key === 0 && $value[0] === 'emails') {
                $data[$key][1] = 'validation';
                continue;
            }
            if (empty($value[0]) || !$this->validMail($value[0])) {
                $data[$key][1] = 'not valid';
                continue;
            }
            $data[$key][1] = 'valid';
            $producer = Yii::$app->rabbitmq->getProducer('send_email');
            $msg = json_encode(['email' => $value[0], 'subject' => $subject, 'body' => $body]);
            $producer->publish($msg, 'exchange2', 'send_email');

        }
        SheetService::write($data, $fileName);

        //hint: issue in rabbitmq package That MSG_REJECT should be 0 and MSG_ACK should be 1

        return ConsumerInterface::MSG_REJECT;
    }

    private function validMail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

}