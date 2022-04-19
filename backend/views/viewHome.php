<div class="home">
    <img src="" alt="home_img" class="img" />
    <div class="data">
        <div class="title"><?= $user->name() ?></div>
        <div class="mail"><?= $user->email() ?></div>
        <div class="online">
            <div class="dot"></div>
            <span><?= $user->online()>0 ? 'online' : 'offline' ?></span>
        </div>
    </div>
    <div class="logout">
        <button class="btn">logout</button>
    </div>
</div>
<script type="module" src="./js/home.js"></script>
