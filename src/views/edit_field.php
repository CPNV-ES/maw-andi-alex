<header class="header">
    <a href="/">
        <img src="/static/logo.png" class="logo" alt="logo">
    </a>
    <p class="header-context"><span>Exercise: </span><span><?= $exercise->title ?></span></p>
</header>
<div class="content">
    <h1>Editing field</h1>
    <form class="form" action="/exercises" method="POST">
        <label for="label">Label</label>
        <input id="label" type="text" name="label">
        <label for="type">Value kind</label>
        <select name="type" id="type">
            <option value="single_line" selected>Single line text</option>
            <option value="single_line_list">List of single lines</option>
            <option value="multi_line">Multi-line text</option>
        </select>
        <input class="button button-purple" type="submit" value="Create field">
    </form>
    </form>
</div>