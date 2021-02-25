<?php
namespace App\Repositories\Story;

use App\Repositories\BaseRepository;
use App\Models\Story;
use Illuminate\Support\Carbon;

class StoryRepository extends BaseRepository implements StoryRepositoryInterface
{
    public function getModel()
    {
        return Story::class;
    }
    
    public function getListStory()
    {
        return Story::with('user')->orderBy('created_at', 'desc')->get();
    }

    public function deleteStory()
    {
        return Story::where('created_at', '<=', Carbon::now()->subMinute())
            ->delete();
    }
}
