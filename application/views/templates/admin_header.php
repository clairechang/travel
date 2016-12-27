<style>
a:link, a:visited {
    background-color: rgb(125, 165, 126);
    color: white;
    padding: 5px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    margin: 1px 1px 1px 1px; 
    
}

a:hover, a:active {
    background-color: red;
}
</style>

<div>
<?php if ($this->session->userdata('logged_in')):?>
		<a href='/admin_member/index'>個人資料</a>
		<a href='/admin_note/index'>旅遊雜記</a>
		<a href='/admin_board/index'>留言板</a>
		<a href='/admin_member/logout'>登出管理介面</a>
<?php endif; ?>

</div>
	
  