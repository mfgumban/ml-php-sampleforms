'use strict';

function get(context, params) {
  var expenseId = params.expenseId || null;
  if (!expenseId) {
    context.outputStatus = [400, "Bad Request"];
  }

  var directory = '/expense/' + expenseId + '/';
  return fn.head(xdmp.directory(directory));
}

exports.GET = get;