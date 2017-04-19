<?php

namespace Drupal\commerce_wire\PluginForm\WireGateway;

use Drupal\commerce_payment\PluginForm\PaymentMethodAddForm as BasePaymentMethodAddForm;
use Drupal\Core\Form\FormStateInterface;

class PaymentMethodAddForm extends BasePaymentMethodAddForm {

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state){
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['payment_details'] = $this->buildWireTransferForm($form['payment_details'], $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function buildWireTransferForm(array $element, FormStateInterface $form_state) {
    $element['wire_transfer_receipt'] = [
      '#title' => t('Receipt'),
      '#type' => 'managed_file',
      '#description' => t('The uploaded image will be displayed on this page using the image style choosen below.'),
      '#upload_location' => 'public://receipt/'
    ];
    return $element;
  }

}
