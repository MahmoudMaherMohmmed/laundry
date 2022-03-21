<?php


namespace App\Http\Services;

use App\Http\Repository\CountryRepository;
use Illuminate\Support\Arr;

class CountryService
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * __construct
     *
     * @param  CountryRepository $countryRepository
     * @return void
     */
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository  = $countryRepository;
    }
    /**
     * handle function that make update for country
     * @param array $request
     * @return Country
     */ 
    public function handle($request, $countryId = null)
    {
        $country = $this->countryRepository;

        if($countryId) {
            $country = $this->countryRepository->find($countryId);
        }

        foreach ($request['title'] as $key => $value) {
            $country->setTranslation('title', $key, $value);
        }

        $country->fill(Arr::except($request, ['title']));

        $country->save();

    	return $country;
    }

}
