<?php
use yii\helpers\Html;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var app\models\user\BankForm $model */
/** @var array $clubsList */

$this->title = 'Управление банком';
$clubs = \app\models\club\Club::find()->asArray()->all();
$historyList = \app\models\admin\Transaction::find()->asArray()->all();
?>
<link rel="stylesheet" href="../../css/main.css">
<style>
</style>
<div class="bank-body">

    <?= $this->render('//layouts/header') ?>
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="flash-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
        <?php elseif(Yii::$app->session->hasFlash('error')): ?>
            <div class="flash-error">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
    <?php endif; ?>
    <div class="page-container">
        
        <main class="main-bank">
    
            <form class="card-block" method="post" action="<?= Url::to(['admin/bank']) ?>">

                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">

                <div class="block-title">
                    <h1>Операция с баллами</h1>
                </div>

                <div class="form-group">
                    <label for="club">Клуб</label>
                    <select name="BankForm[clubId]" id="club" class="form-control">
                        <option disabled selected hidden>-- Выберите клуб --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="amount">Сумма</label>
                    <input type="number" id="amount" name="BankForm[amount]" class="form-control" placeholder="100 или -100">
                </div>

                <div class="form-group">
                    <label for="comment">Комментарий</label>
                    <textarea id="comment" name="BankForm[comment]" class="form-control" placeholder="Комментарий к операции"></textarea>
                </div>

                <button type="submit" class="button-submit-bank">Выполнить операцию</button>

            </form>
            <div class="card-block">
                <div class="block-title">
                    <h1>Балансы клубов</h1>
                </div>

                <div class="clubs-balance-list" id="clubs-list"></div>
            </div>

        </main>

        <div class="card-block history-block">
            <div class="block-title">
                <h1>История операций</h1>
            </div>

            <div class="history-list" id="history-list">
                
            </div>
        </div>

        <a href="<?= Url::to(['admin/admin']) ?>" class="button-back">← Назад в админ-панель</a>

    </div>
</div>
<template id="club-template">
    <div class="club-balance-item">
        <span class="club-name"></span>
        <span class="club-points"></span>
    </div>
</template>

<template id="history-transaction-template">
    <div class="history-item">
        <div class="history-header">
            <span class="history-club-name"></span>
            <span class="history-points"></span>
        </div>
        <div class="history-comment">
            <strong>Комментарий:</strong>
            <p></p>
        </div>
    </div>
</template>
<script>
const clubs = <?= json_encode($clubs) ?>;
const historyList = <?= json_encode($historyList) ?>;
clubs.forEach(club => {
    let club_balance = document.getElementById('club-template').content.cloneNode(true);

    club_balance.querySelector('.club-name').textContent = club.name;
    club_balance.querySelector('.club-points').textContent = club.balance + ' баллов';

    document.getElementById('clubs-list').appendChild(club_balance);
});

historyList.forEach(history =>{
    let club_name = clubs.find(club => club.id == history.club_id);
    let HistoryCard = document.getElementById('history-transaction-template').content.cloneNode(true);
    HistoryCard.querySelector('.history-club-name').textContent = club_name.name;
    HistoryCard.querySelector('.history-points').textContent = history.value;
    if (history.comment) {
        HistoryCard.querySelector('.history-comment p').textContent = history.comment;
    } else {
        HistoryCard.querySelector('.history-comment').remove();
    }

    document.getElementById('history-list').appendChild(HistoryCard);
})


clubs.forEach(club => {
    let option = document.createElement('option');

    option.value = club.id;
    option.textContent = club.name;

    document.getElementById('club').appendChild(option);
});
    if(document.querySelector('.flash-success')){
        setTimeout(() => {
            document.querySelector('.flash-success').remove()
        }, 3000);
    }
    else if(document.querySelector('.flash-error')){
        setTimeout(() => {
            document.querySelector('.flash-error').remove()
        }, 3000);
    }
</script>
