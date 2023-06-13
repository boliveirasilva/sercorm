<?php

namespace SercORM\Core;

use ADOConnection;

class ConnectionDB
{
    /** @var array */
    private $db_settings = [];

    /** @var ADOConnection */
    private $ado;

    /**
     * @param array $db_settings
     */
    public function __construct(array $db_settings)
    {
        $this->db_settings = $db_settings;
    }

    /**
     * @return ADOConnection
     */
    public function getNewConnection()
    {
        $this->makeConnection($this->db_settings);

        $this->postConnectionConfigs($this->db_settings);

        return $this->ado;
    }

    /**
     * Makes a new ADOConnection instance.
     *
     * @param array $settings Database connection settings
     * @return void
     */
    private function makeConnection(array $settings)
    {
        $old_reporting_value = ini_set('error_reporting', E_ERROR);

        $this->ado = NewADOConnection($settings['driver']);
        $this->ado->Connect(
            $settings['host'],
            $settings['user'],
            $settings['pass'],
            $settings['database']
        );

        if ($old_reporting_value !== false) ini_set('error_reporting', $old_reporting_value);

        if (!$this->ado->IsConnected()) $this->failedConnection($settings);
    }

    /**
     * Message for connection fail.
     *
     * @param array $connection_settings
     * @return void
     */
    protected function failedConnection(array $connection_settings)
    {
        echo '<h2>Não foi possível realizar a conexão com o banco!</h2>';
        echo '<small style="color: red">', "Mensagem: ({$this->ado->ErrorNo()}) {$this->ado->ErrorMsg()}", '</small>';
        echo '<hr>';

        echo '<br>', 'Confira os dados de conexão:', '<br><pre>',
        json_encode($connection_settings, JSON_PRETTY_PRINT);

        exit(1);
    }

    /**
     * @param array $settings
     *
     * @return void
     */
    protected function postConnectionConfigs(array $settings)
    {
        $this->ado->debug = $settings['debug_connection'];
        $this->ado->SetFetchMode(ADODB_FETCH_ASSOC);
    }
}