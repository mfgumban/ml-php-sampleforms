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
        "feedback": {
          "category": source.category || null,
          "message": source.feedback || null,
          "submittedBy": source.anonymous ? "anonymous" : source.email,
          "submittedOn": timestamp.toObject() // save timestamp as something JS can parse
        }
      },
      // save a "raw" copy of the input
      "source": source 
    }
  };

  // add to database
  xdmp.documentInsert("/feedback/" + sem.uuidString() + ".json", doc, {
    collections: ["feedback"]
  });

  // return response
  context.outputStatus = [201, "Created"];
}

exports.PUT = put;