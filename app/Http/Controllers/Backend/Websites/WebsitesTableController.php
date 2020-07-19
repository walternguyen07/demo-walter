<?php

namespace App\Http\Controllers\Backend\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Websites\ManageWebsiteRequest;
use App\Repositories\Backend\Websites\WebsiteRepository;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class WebsitesTableController.
 */
class WebsitesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var WebsiteRepository
     */
    protected $website;

    /**
     * contructor to initialize repository object
     * @param WebsiteRepository $website ;
     */
    public function __construct(WebsiteRepository $website)
    {
        $this->website = $website;
    }

    /**
     * This method return the data of the model
     * @param ManageWebsiteRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageWebsiteRequest $request)
    {
        return Datatables::of($this->website->getForDataTable())
            ->escapeColumns(['id'])
            ->escapeColumns(['website_url'])
            ->escapeColumns(['country_id'])
            ->addColumn(
                'created_at',
                function ($website) {
                    return Carbon::parse($website->created_at)->toDateString();
                }
            )
            ->addColumn(
                'actions',
                function ($website) {
                    return $website->action_buttons;
                }
            )
            ->make(true);
    }
}
