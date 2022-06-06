<?php

function sanitizeString($type, $field) {
  return filter_input($type, $field, FILTER_SANITIZE_STRING);
}