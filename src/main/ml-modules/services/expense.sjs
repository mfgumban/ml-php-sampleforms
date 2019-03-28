'use strict';

function put(context, params, input) {
  // the JSON payload
  var source = input.toObject();
  var timestamp = fn.currentDateTime();

  // construct document
  var doc = {
    "envelope": {
      // internal metadata
      "headers": {
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
  var expenseId = sem.uuidString();
  xdmp.documentInsert("/expense/" + expenseId + ".json", doc, {
    collections: ["expense"]
  });

  // return response
  context.outputStatus = [201, "Created"];
  return {
    "expenseId": expenseId
  };
}

exports.PUT = put;