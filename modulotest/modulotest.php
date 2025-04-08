<?php

class ModuloTest extends Module 
{
    public function __construct()
    {
        $this->name = 'modulotest';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Samuel Osorio';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Modulo Test');
        $this->description = $this->l('Este es un módulo de prueba para PrestaShop.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        return parent::install() && $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');
        return parent::uninstall();
    }

    public function hookDisplayHome()
    {
        return "Mostrar texto en el hook de la página de inicio";
    }
     public function hookDisplayBackOfficeHeader()
     {
        if(Tools::getValue(('configure') == $this->name)) {
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
            $this->context->controller->addJS($this->_path . 'views/css/back.css');
        }
     }
    public function getContent()
    {
        $titulo = 'titulo';
        $contenido = '';

        if ((bool)Tools::isSubmit('btnSubmit') === true) {
            $texto = Tools::getValue('print');
            $contenido = $texto;
        }

        if ((bool)Tools::isSubmit('btnSubmitHelp') === true) {
            $texto = Tools::getValue('PS_TEXT');
            $contenido = $texto;
        }

        $this->context->smarty->assign([
            'titulo' => $titulo,
            'contenido' => $contenido
        ]);

        $output = $this->display(__FILE__, 'views/templates/admin/configure.tpl');
        return $output . $this->renderForm();
    }

    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'btnSubmitHelp';

        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;

        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => 'Titulo de HelperForm',
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => 'Escribe el texto que quieres mostrar',
                        'label' => 'Texto',
                        'name' => 'PS_TEXT',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Guardar'),
                    'class' => 'btn btn-default pull-right'
                )
            )
        );
    }

    protected function getConfigFormValues()
    {
        return array(
            'PS_TEXT' => Configuration::get('PS_TEXT', ''),
        );
    }
}
