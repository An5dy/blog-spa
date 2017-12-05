<?php

namespace App\Policies;

use App\User;
use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the modelsArticle.
     *
     * @param  \App\User  $user
     * @param  \App\ModelsArticle  $modelsArticle
     * @return mixed
     */
    public function view(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can create modelsArticles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the modelsArticle.
     *
     * @param  \App\User  $user
     * @param  \App\ModelsArticle  $modelsArticle
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        return $user->id == $article->user_id;
    }

    /**
     * Determine whether the user can delete the modelsArticle.
     *
     * @param  \App\User  $user
     * @param  \App\ModelsArticle  $modelsArticle
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
        return $user->id == $article->user_id;
    }
}
