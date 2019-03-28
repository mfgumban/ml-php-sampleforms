'use strict';

function get(context, params) {
  // return static document
  return cts.doc("/settings/expenseTypes.json");
}

exports.GET = get;