<?php
namespace App\Repositories\Story;

use App\Repositories\BaseRepository;
use App\Models\Story;

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
}
