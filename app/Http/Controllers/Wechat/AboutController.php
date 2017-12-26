<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\Article;
use App\Repositories\ArticleCategoryList;
use App\Repositories\ArticleList;
use App\Repositories\Config;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/7
 * Time: 15:08
 * Author: wenlongh <wenlongh@qq.com>
 */
class AboutController extends Controller
{
    public function index()
    {
        $category = ArticleCategoryList::getAll(['type' => 'about_we', 'status' => 1]);
        $keyBy = $category->getItems()->keyBy('id');
        $cond = [
            'status' => 1,
            function ($q) use ($keyBy) {
                $q->whereIn('category_id', $keyBy->keys()->toArray());
            },
        ];
        $article = ArticleList::getAll($cond);
        $data = [
            'rows' => $article->getItems(),
        ];

        return view('wechat.about.index', $data);
    }

    public function articleDetails($id)
    {
        $article = Article::initById($id);
        $data = [
            'row' => $article->getData(),
        ];

        return view('wechat.about.article_details', $data);
    }

    public function explainArticle($key)
    {
        $data = [
            'content' => $config = Config::get($key, ''),
        ];

        return view('wechat.about.explain_article', $data);
    }
}