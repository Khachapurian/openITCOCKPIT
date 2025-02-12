<div id="angularacknowledgeServiceModal" class="modal z-index-2500" role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-user"></i>
                    <?php echo __('Acknowledge service status'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group required" ng-class="{'has-error': ack.error}">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-prepend fa fa-pencil-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="<?php echo __('Comment'); ?>"
                                   ng-model="ack.comment">
                        </div>
                        <div class="col-md-12 no-padding" ng-show="ack.error">
                            <div class="help-block text-danger">
                                <?= __('Comment can not be empty'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 margin-top-10">

                        <div class="custom-control custom-checkbox  margin-bottom-10">
                            <input type="checkbox"
                                   name="checkbox"
                                   class="custom-control-input"
                                   checked="checked"
                                   ng-model="ack.sticky"
                                   id="ackSticky">
                            <label class="custom-control-label" for="ackSticky">
                                <?php echo __('Sticky'); ?>
                            </label>
                        </div>
                        <div class="helptext help-block">
                            <?php echo __('Sticky acknowledgements will be stay until the service is back in state Ok'); ?>
                        </div>
                    </div>

                    <div class="col-lg-12 margin-top-10">

                        <div class="custom-control custom-checkbox  margin-bottom-10">
                            <input type="checkbox"
                                   name="checkbox"
                                   class="custom-control-input"
                                   checked="checked"
                                   ng-model="ack.notify"
                                   id="ackNotify">
                            <label class="custom-control-label" for="ackNotify">
                                <?php echo __('Notify'); ?>
                            </label>
                        </div>
                        <div class="helptext help-block">
                            <?php echo __('The system will send a notification to inform contacts that the current service problem has been acknowledged.'); ?>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 margin-top-10" ng-show="doAck">
                    <h4><?php echo __('Executing command'); ?></h4>
                </div>
                <div class="col-lg-12 margin-top-10" ng-show="doAck">
                    <div class="progress progress-striped active">
                        <div class="progress-bar bg-primary" style="width: {{percentage}}%"></div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" ng-click="doAcknowledgeService()">
                    <?php echo __('Save'); ?>
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo __('Close'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
