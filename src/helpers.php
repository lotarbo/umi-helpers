<?php

if (! function_exists('is_ajax')) {
    /**
     * Проверка что пришел ajax запрос
     *
     * @return bool
     */
    function is_ajax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}

if (! function_exists('send_json')) {
    /**
     * Отправить json в ответ
     *
     * @param  array  $data
     * @param  array  $headers
     * @return void
     */
    function send_json(array $data = [], array $headers = [])
    {
        $buffer = outputBuffer::current();
        /* @var HTTPOutputBuffer $buffer */
        // $buffer->clear(); добавить в режиме работы debug=0
        $buffer->contentType('text/javascript');
        $buffer->option('generation-time', false);
        $buffer->status(200);

        if (is_array($headers) && count($headers)) {
            foreach ($headers as $name => $value) {
                $value = (string)$value;
                $buffer->setHeader($name, $value);
            }
        }

        $buffer->push(json_encode($data, JSON_UNESCAPED_UNICODE));
        $buffer->end();

        die;
    }
}
