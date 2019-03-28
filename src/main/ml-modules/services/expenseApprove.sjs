'use strict';

function put(context, params) {
  var expenseId = params.expenseId || null;
  if (!expenseId) {
    context.outputStatus = [400, "Bad Request"];
  }

  var timestamp = fn.currentDateTime();
  var uri = '/expense/' + expenseId + '.json';
  var doc = cts.doc(uri).toObject(); // retrieve document and convert to a JSON object

  // update
  doc.envelope.modifiedOn = timestamp;
  doc.envelope.content.expense.status = "Approved";
  doc.envelope.content.expense.approvedOn = timestamp.toObject();
  xdmp.documentInsert(uri, doc, {
    collections: ["expense"]
  });

  // return response
  context.outputStatus = [204, "Content Updated"];
  return {
    "expenseId": expenseId
  };
}

exports.PUT = put;