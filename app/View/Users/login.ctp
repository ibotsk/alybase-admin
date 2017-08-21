<div class="container">
    <div class="jumbotron">
        <h2>AlybaseAdmin</h2>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 col-xs-12">
            <?php
            echo $this->Flash->render('auth');
            echo $this->Form->create('User');
            echo $this->Form->input('username', array('type' => 'text', 'label' => 'Username:', 'div' => 'form-group', 'class' => 'form-control'));
            echo $this->Form->input('password', array('type' => 'password', 'label' => 'Password:', 'div' => 'form-group', 'class' => 'form-control'));
            echo $this->Form->end(array('class' => 'btn btn-default', 'div' => false));
            ?>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>

