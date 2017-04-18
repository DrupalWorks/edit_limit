<?php

namespace Drupal\edit_limit\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;

class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['edit_limit.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'edit_limit_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // TODO both node and or comment are not required anymore.


    $config = $this->config('edit_limit.settings');

    $form['enabled'] = array(
      '#type' => 'fieldset',
      '#title' => t('Enabled options'),
      '#collapsible' => FALSE,
    );
    $form['enabled']['node_time_enabled'] = array(
      '#type' => 'checkbox',
      '#title' => t('Enable node time limits'),
      '#description' => t('If enabled, nodes can only be edited within the given time frame.'),
      '#default_value' => $config->get('node_time_enabled'),
    );
    $form['enabled']['comment_time_enabled'] = array(
      '#type' => 'checkbox',
      '#title' => t('Enable comment time limits'),
      '#description' => t('If enabled, comments can only be edited within the given time frame.'),
      '#default_value' => $config->get('comment_time_enabled'),
    );
    $form['enabled']['node_count_enabled'] = array(
      '#type' => 'checkbox',
      '#title' => t('Enable node count limits'),
      '#description' => t('If enabled, nodes can only be edited a certain number of times.'),
      '#default_value' => $config->get('node_count_enabled'),
    );

    // TODO: Make the time unit changeable. Currently seconds.
    $form['node_limits'] = array(
      '#type' => 'fieldset',
      '#title' => t('Node limits'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );
    $time_units = array();
    foreach (explode(',', t(EDIT_LIMIT_TIME_UNITS, ['@seconds' => 'seconds', '@minutes' => 'minutes', '@hours' => 'hours', '@days' => 'days'])) as $unit) {
      $time_units[$unit] = $unit;
    }
    $form['node_limits']['node_time_unit'] = array(
      '#type' => 'select',
      '#title' => t('Node time unit'),
      '#options' => $time_units,
      '#default_value' => $config->get('node_time_unit'),
    );
    $form['node_limits']['node_time_default'] = array(
      '#type' => 'textfield',
      '#title' => t('Node time limit'),
      '#description' => t('The amount of time after a node has been saved that it can be edited (in unit selected above).'),
      '#size' => 10,
      '#default_value' => $config->get('node_time_default'),
      '#maxlength' => 10,
    );
    $form['node_limits']['node_count_default'] = array(
      '#type' => 'textfield',
      '#title' => t('Edit count'),
      '#description' => t('The number of times a node can be edited, after the original submission.'),
      '#size' => 4,
      '#default_value' => $config->get('node_count_default'),
      '#maxlength' => 4,
    );
    $types = array();
    foreach (NodeType::loadMultiple() as $type_data) {
      $types[$type_data->id()] = $type_data->label();
    }
    asort($types);

    $default_node_types = $config->get('node_types');
    if (!is_array($default_node_types)) {
      $default_node_types = [];
    }
    $form['node_limits']['node_types'] = array(
      '#type' => 'select',
      '#title' => t('Content types'),
      '#description' => t('Select the content types to apply these node limits to. Only content types selected here will have any limits applied.'),
      '#multiple' => TRUE,
      '#options' => $types,
      '#default_value' => $default_node_types,
    );

    // TODO: Make the time unit changeable. Currently seconds.
    $form['comment_limits'] = array(
      '#type' => 'fieldset',
      '#title' => t('Comment limits'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );
    $form['comment_limits']['comment_time_unit'] = array(
      '#type' => 'select',
      '#title' => t('Node time unit'),
      '#options' => $time_units,
      '#default_value' => $config->get('comment_time_unit'),
    );
    $form['comment_limits']['comment_time'] = array(
      '#type' => 'textfield',
      '#title' => t('Comment time limit'),
      '#description' => t('The amount of time after a comment has been saved that it can be edited (in unit selected above).'),
      '#size' => 10,
      '#default_value' => $config->get('comment_time'),
      '#maxlength' => 10,
    );

    $default_comment_types = $config->get('comment_types');
    if (!is_array($default_node_types)) {
      $default_comment_types = [];
    }
    $form['comment_limits']['comment_types'] = array(
      '#type' => 'select',
      '#title' => t('Content types'),
      '#description' => t('Select the content types to apply these comment limits to. Only comments related to the content types selected here will have any limits applied.'),
      '#multiple' => TRUE,
      '#options' => $types,
      '#default_value' => $default_comment_types,
    );


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('edit_limit.settings');

    $keys = [
      'node_time_enabled',
      'comment_time_enabled',
      'node_count_enabled',
      'node_time_unit',
      'node_time_default',
      'node_count_default',
      'node_types',
      'comment_time_unit',
      'comment_time',
      'comment_types'
    ];

    foreach ($keys as $key) {
      $config->set($key, $form_state->getValue($key));
    }

    $config->save();

    parent::submitForm($form, $form_state);
  }

}
