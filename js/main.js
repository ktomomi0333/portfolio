"use strict";
// エラーチェック

{
  const open =document.getElementById('open');
  // 定数の設定　変更不可
  // IDをとってくるよ　getElementById
  // querySelector クラス、要素、idなんでもとってこれるよ
  const overlay = document.querySelector('.overlay');
  const close = document.getElementById('close');

  // ハンバーガーメニューをクリックしたらshowを表示される
  open.addEventListener('click', () => {
    overlay.classList.add('show');
    open.classList.add('hide');
  });

  close.addEventListener('click', () => {
    overlay.classList.remove('show');
    open.classList.remove('hide');
  });
  
}