<header class="header">
    <a href="/">
        <img src="/static/logo.png" class="logo" alt="logo">
    </a>
</header>
<div class="content">
    <h1>New Exercise</h1>
    <form class="form" action="/exercises" method="POST">
        <label for="title">Title</label>
        <input id="title" type="text" name="title">
        <input class="button button-purple" type="submit" value="Create exercise">
    </form>
</div>