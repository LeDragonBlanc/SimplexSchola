const express = require('express');
const bodyParser = require('body-parser');
const { MongoClient } = require('mongodb');
const app = express();
const port = 3000;

app.use(bodyParser.json());
app.use(express.static('public'));

const url = 'mongodb://mongo:27017';
const dbName = 'groupe_etude';
let db;

MongoClient.connect(url, { useNewUrlParser: true, useUnifiedTopology: true }, (err, client) => {
  if (err) {
    console.error(err);
    process.exit(1);
  }
  db = client.db(dbName);
  console.log(`Connected to database ${dbName}`);
});

app.post('/create-group', (req, res) => {
  const { groupName, description, subjects } = req.body;
  const collection = db.collection('groupes');
  collection.insertOne({ groupName, description, subjects }, (err, result) => {
    if (err) {
      res.status(500).json({ error: 'Error creating group' });
      return;
    }
    res.status(201).json({ message: 'Group created successfully' });
  });
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
