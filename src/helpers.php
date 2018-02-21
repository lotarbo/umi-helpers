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
     * @param  int  $status
     *
     * @return void
     */
    function send_json(array $data = [], array $headers = [] , $status = 200)
    {
        $buffer = outputBuffer::current();
        /* @var HTTPOutputBuffer $buffer */

        $buffer->contentType('text/javascript');
        $buffer->charset('utf-8');
        $buffer->option('generation-time', false);
        $buffer->clear();
        $buffer->status($status);

        if (is_array($headers) && count($headers)) {
            foreach ($headers as $name => $value) {
                $value = (string) $value;
                $buffer->setHeader($name, $value);
            }
        }

        $buffer->push(json_encode($data, JSON_UNESCAPED_UNICODE));
        $buffer->end();
    }
}

if (! function_exists('render')) {
    /**
     * Рендерит шаблон $template. Аналог $umiTemplaterPHP->render();
     *
     * @param string|array $data данные для шаблона
     * @param string $template файл шаблона
     * @param string $type тип шаблонизатора
     * @param mixed $templatesSource источник шаблонов
     *
     * @return string
     *
     * @throws coreException
     */
    function render($data, $template, $type = 'php', $templatesSource = null)
    {
        $engine = umiTemplater::create($type, $templatesSource);
        return $engine->render($data, $template);
    }
}

if (! function_exists('config')) {
    /**
     * Возвращает значение из config.ini, если нету его, то вернет $default
     *
     * @param string $section
     * @param string $variable
     * @param null|string $default
     *
     * @return null|string
     */
    function config($section, $variable, $default = NULL)
    {
        $config = mainConfiguration::getInstance();
        $value = $config->get($section, $variable);

        return NULL === $value ? $default : $value;
    }
}
