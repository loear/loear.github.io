<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    //TODO : 列表页
    public function index()
    {
        $data = DB::table("msg_article")
            ->field('id, title, time, viewnum')
            ->where('status', 'A')
            ->order('time', 'desc')
            ->paginate(10);

        $this->assign('data', $data);

        return $this->fetch();
    }

    //TODO : 写留言
    public function create()
    {
        return $this->fetch();
    }

    public function subcreate()
    {
        $title   = isset($_POST['title']) ? $_POST['title'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $time    = time();

        $id = DB::table('msg_article')
            ->insertGetId(array('title' => $title, 'content' => $content, 'time' => $time));

        if ($id) {
            $this->success('成功', 'index');
        } else {
            $this->error('失败', 'index');
        }

    }

    //TODO : 编辑留言
    public function update($id)
    {
        $data = DB::table('msg_article')
            ->field('id, title, content')
            ->where(array('id' => $id))
            ->find();

        $this->assign('data', $data);
        return $this->fetch();
    }

    public function subupdate($id)
    {
        $title   = isset($_POST['title']) ? $_POST['title'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $time    = time();

        $id = Db::table('msg_article')
            ->where(array('id' => $id))
            ->update(array('title' => $title, 'content' => $content, 'time' => $time));

        if ($id) {
            $this->success('成功', 'index');
        } else {
            $this->error('失败', 'index');
        }
    }

    //TODO : 删除留言
    public function delete($id)
    {
        $id = DB::table('msg_article')
            ->where(array('id' => $id))
            ->update(array('status' => 0));

        if ($id) {
            $this->success('成功', 'index');
        } else {
            $this->error('失败', 'index');
        }
    }

    //TODO : 查看
    public function view($id)
    {
        DB::table('msg_article')
            ->where(array('id' => $id))
            ->setInc('viewnum');

        $data = DB::table('msg_article')
            ->field('id, title, content, viewnum, time')
            ->where(array('id' => $id))
            ->find();

        $this->assign('data', $data);
        return $this->fetch();
    }

}
