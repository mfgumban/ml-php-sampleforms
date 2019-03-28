'use strict';

var jsearch = require('/MarkLogic/jsearch.sjs');

function get(context, params) {
  var qtext = params.qtext || null;
  var query = [ cts.collectionQuery('expense') ];
  if (qtext) {
    query.push(cts.wordQuery(qtext));
  }

  return jsearch.documents()
    .where(query)
    .map(function(item) {
      // the results of jsearch can be verbose, so we'll edit the results
      return {
        uri: item.uri,
        expenseId: item.document.envelope.headers.expenseId,
        expense: item.document.envelope.content.expense
      };
    })
    .result();
}

function put(context, params, input) {
  // the JSON payload
  var source = input.toObject();
  var timestamp = fn.currentDateTime();
  var expenseId = sem.uuidString();
  
  // construct document
  var doc = {
    "envelope": {
      // internal metadata
      "headers": {
        "expenseId": expenseId,
        "createdOn": timestamp // save timestamp "as-is" so it can be indexed
      },
      // the canonical or preferred structure of the data
      "content": {
        "expense": {
          "type": source.expenseType || null,
          "reimbursable": source.reimbursable === 'yes',
          "reason": source.reason || null,
          "submittedBy": source.name,
          "submittedOn": timestamp.toObject(), // save timestamp as something JS can parse
          "status": "Open"
        }
      },
      // save a "raw" copy of the input
      "source": source 
    }
  };

  // add to database
  xdmp.documentInsert("/expense/" + expenseId + ".json", doc, {
    collections: ["expense"]
  });

  // return response
  context.outputStatus = [201, "Created"];
  return {
    "expenseId": expenseId
  };
}

exports.GET = get;
exports.PUT = put;