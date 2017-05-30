<?php
namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
    /**
     * Auth service.
     * @var Zend\Authentication\Authentication
     */
    private $authService;
    
    /**
     * Url view helper.
     * @var Zend\View\Helper\Url
     */
    private $urlHelper;
    
    /**
     * translatorManager
     * @var Zend\View\Helper\Url
     */
    private $translatorManager;
    
    /**
     * Constructs the service.
     */
    public function __construct($authService, $urlHelper, $translatorManager) 
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->translatorManager = $translatorManager;
    }
	
    function translate($str) 
	{ 
		return $this->translatorManager->translate($str);
	}

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems() 
    {
        $url = $this->urlHelper;
        $items = [];
        
        $items[] = [
            'id' => 'home',
            'label' =>  $this->translate("Inici"),
            'link'  => $url('home')
        ];
        
        $items[] = [
            'id' => 'about',
            'label' => $this->translate("sobre"),
            'link'  => $url('about')
        ];
        
        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => $this->translate("Entrar"),
                'link'  => $url('login'),
                'float' => 'right'
            ];
        } else {
            
            $items[] = [
                'id' => 'moviment',
                'label' => $this->translate("Assentaments"),
                'dropdown' => [
                    [
                        'id' => 'moviment',
                        'label' => $this->translate("simple"),
                        'link' => $url('llista')
                    ],
                    [
                        'id' => 'comptes',
                        'label' => $this->translate("múltiple"),
                        'link' => $url('comptes')
                    ],
                    [
                        'id' => 'importar',
                        'label' => $this->translate("importar"),
                        'link' => $url('importar')
                    ]
                ]
			];
			
            $items[] = [
                'id' => 'admin',
                'label' => $this->translate("Admin"),
                'dropdown' => [
                    [
                        'id' => 'users',
                        'label' => $this->translate("Gestió d'Usuaris"),
                        'link' => $url('users')
                    ],
                    [
                        'id' => 'comptes',
                        'label' => $this->translate("Gestió de Comptes"),
                        'link' => $url('comptes')
                    ]
                ]
            ];
            
            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'float' => 'right',
                'dropdown' => [
                    [
                        'id' => 'settings',
                        'label' => $this->translate("ajustos"),
                        'link' => $url('application', ['action'=>'settings'])
                    ],
                    [
                        'id' => 'logout',
                        'label' => $this->translate("Sortir"),
                        'link' => $url('logout')
                    ],
                ]
            ];
        }
        
        return $items;
    }
}


