<?php

namespace OAuth2Demo\Server\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class Resource
{
    // Connects the routes in Silex
    public static function addRoutes($routing)
    {
        $routing->get('/resource', array(new self(), 'resource'))->bind('access');
    }

    /**
     * This is called by the client app once the client has obtained an access
     * token for the current user.  If the token is valid, the resource (in this
     * case, the "plans" of the current user) will be returned to the client
     */
    public function resource(Application $app)
    {
        // get the oauth server (configured in src/OAuth2Demo/Server/Server.php)
        $server = $app['oauth_server'];

        // get the oauth response (configured in src/OAuth2Demo/Server/Server.php)
        $response = $app['oauth_response'];

        if (!$server->verifyResourceRequest($app['request'], $response)) {
            return $server->getResponse();
        } else {
            // return a fake API response - not that exciting
            $apiResponse = array(
                'plans' => array(
                    '/images/Death_Star_Owner\'s_Technical_Manual_blueprints.jpg',
                    '/images/Deathstar_blueprint.jpg',
                    '/images/DSOTM-1088x816-651507587451.jpg',
                    '/images/jasb1.gif',
                ),
                'type' => 'Imperial superweapon',
                'purpose' => 'Destroy the rebel alliance and gain full control of the galaxy',
                'description' => 'The idea for the Death Star began when the Confederacy of Independent Systems designed the Ultimate Weapon, using plans and concepts provided by Wilhuff Tarkin. Poggle the Lesser possessed the original (or a copy of the) plans, which he handed to Count Dooku during the First Battle of Geonosis.
Darth Tyranus attempted to flee the planet and go to Coruscant, but he was intercepted by Obi-Wan Kenobi, Anakin Skywalker, and Yoda who sought to capture him. Tyranus defeated the two Knights; however, Yoda, in order to save the other two, let Tyranus escape with the plans. The future of the galaxy was strongly affected by this decision.
Tyranus managed to arrive at the Works of Coruscant and he delivered the schematics personally to Darth Sidious. Once the Clone Wars were over, Palpatine shaped this idea for his own purposes. Blueprints were used as a basis for construction of the station, and, after the Death Star\'s completion, the plans became a prime target for the Rebellion, whose members hoped to find and exploit a weakness in the superweapon. In large part because of this, the Empire split up the plans and sent it to various places of the galaxy to prevent enemy hands from acquiring it.',
            );
            return new Response(json_encode($apiResponse));
        }
    }
}
