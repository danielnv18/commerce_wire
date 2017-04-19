<?php

namespace Drupal\commerce_wire\Plugin\Commerce\PaymentMethodType;

use Drupal\commerce\BundleFieldDefinition;
use Drupal\commerce_payment\Entity\PaymentMethodInterface;
use Drupal\commerce_payment\Plugin\Commerce\PaymentMethodType\PaymentMethodTypeBase;
use Drupal\Core\Url;

/**
 * Provides the credit card payment method type.
 *
 * @CommercePaymentMethodType(
 *   id = "wire_transfer_method",
 *   label = @Translation("Wire Transfer"),
 *   create_label = @Translation("New wire transfer"),
 * )
 */
class WireMethod extends PaymentMethodTypeBase {

  /**
   * {@inheritdoc}
   */
  public function buildLabel(PaymentMethodInterface $payment_method) {
    /*get value object from wire_transfer_receipt*/
    $value = $payment_method->wire_transfer_receipt->getValue();
    /*load the file*/
    $file = file_load($value[0]['target_id']);
    /*get the uri from the file loaded*/
    $uri = $file->getFileUri();
    /*build the full path*/
    $path = file_create_url($uri);
    /*create a url object*/
    $url = Url::fromUri($path, $options = [
      'attributes' => [
        'class' => ['img-payment'],
        'target' => ['_blank'],
      ],
    ]);
    /*build the link*/
    $link = \Drupal::l(t('Receipt'), $url);

    return $link;
  }

  /**
   * {@inheritdoc}
   */
  public function buildFieldDefinitions() {
    $fields = parent::buildFieldDefinitions();

    $fields['wire_transfer_receipt'] = BundleFieldDefinition::create('image')
      ->setLabel(t('Receipt'))
      ->setDescription(t('The receipt of the wire transfer.'))
      ->setRequired(TRUE);

    return $fields;
  }

}
