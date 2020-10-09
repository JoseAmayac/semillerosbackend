<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Documentación API semilleros",
     *      description="Documentación de todos los end points disponibles en la API de semilleros de la UAM",
     *      @OA\Contact(
     *          email="jose.amayac@autonoma.edu.co"
     *      ),
     * *      @OA\Contact(
     *          email="daniel.garciaa@autonoma.edu.co"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url="http://localhost:8000",
     *      description="API server Semilleros UAM"
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
