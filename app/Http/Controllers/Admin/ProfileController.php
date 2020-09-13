<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;
use App\History;
use Carbon\Carbon;

class ProfileController extends Controller
{
  public function add()
  {
      return view('admin.profile.create');
  }

  public function create(Request $request)
  {
      // Varidationを行う
      $this->validate($request, Profile::$rules);

      $profile = new Profile;
      $form = $request->all();

      // データベースに保存する
      $profile->fill($form);
      $profile->save();

      return redirect('admin/profile/create');
  }

  public function edit(Request $request)
  {
      // Profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);
      }
      return view('admin.profile.edit', ['profile_form' => $profile]);
  }

  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Profile::$rules);

      // Profile Modelからデータを取得する
      $profile = Profile::find($request->id);

      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();

      // 該当するデータを上書きして保存する
      $profile->fill($profile_form)->save();

      // 編集履歴も更新
      $history = new History;
      // NewsモデルのIDは不要だが必須入力のため0とする
      $history->news_id = 0;
      $history->profile_id = $profile->id;
      $history->edited_at = Carbon::now();
      $history->save();

      return redirect('admin/profile/edit');
  }

  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Profile::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = Profile::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
}
