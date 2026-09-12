<?php
use yii\helpers\Url;
$user = Yii::$app->user->identity;
?>

<link rel="stylesheet" href="../../css/header.css">
<header>
    <div class="header_first_part">
        <a href = "shop" class="nav-link"><button>Магазин</button></a>
        <a href = "history" class="nav-link"><button>История</button></a>
        <a href = "<?= Url::to(['/club/index', 'id' => $user->club_id]) ?>" class="nav-link"><button>Клуб</button></a>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href = "<?= Url::to(['admin/admin']) ?>" class="nav-link"><button>Админ панель</button></a>
        <?php endif; ?>
    </div>
    <div class="header_second_part">
        <a href = "<?= Url::to(['user/index']) ?>" class="nav-link"><button>Профиль</button></a>
    </div>
</header>
<script>
    document.querySelectorAll('.nav-link').forEach(e => {
        if (e.pathname === window.location.pathname) {
            e.classList.add('active');
        }
    });

</script>