<?php if(!empty($errors)): ?>

<span>Errors (<?= count($errors) ?>)</span>
<ul>
    <?php foreach($errors as $error): ?>
    <li><?= $error ?></li>
    <?php endforeach; ?>
</ul>
<?php endif ?>

<div>
    <label for="title">Title</label>
    <input type="text" id="title" name="title" placeholder="Article title" value="<?= htmlspecialchars($title);?>">
</div>

<div>
    <label for="content">Content</label>
    <textarea name="content" id="content" cols="30" rows="10"><?= htmlspecialchars($content);?></textarea>
</div>

<div>
    <label for="published_at">Publication date and time</label>
    <input type="text" name="published_at" id="published_at" value="<?= htmlspecialchars($published_at);?>">
</div>