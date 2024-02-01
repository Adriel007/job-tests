import express from "express";
import path from "path";
import Database from "./Database";

const app = express();

const port = process.env.PORT || 4568;

const publicDir = path.join(__dirname, 'public');

app.use(express.static(publicDir));
app.use(express.urlencoded({ extended: true }));

const db = new Database();
db.connect();

app.post("/register", (req, res) => {
  if (!req.body) {
    return res.status(400).send("Corpo da solicitação vazio");
  }

  if (req.body.termos !== "on") {
    return res.status(400).send("Aceite os termos de uso");
  }

  if (req.body.cadastrar !== "Cadastrar") {
    return res.status(400).send("Forma de envio inválida");
  }

  if (req.body.confirmar_email !== req.body.email) {
    return res.status(400).send("Emails não correspondem");
  }

  delete req.body.cadastrar;
  delete req.body.termos;
  delete req.body.confirmar_email;

  db.createCliente(req.body, (err: Error | null, clienteId: number | null) => {
    if (err) {
      return res.status(500).send("Erro ao salvar cliente no banco de dados");
    }
    return res.status(200).send(`Cliente registrado com sucesso. ID: ${clienteId}`);
  });
});

app.get("/", (req, res) => {
  return res.sendFile(path.join(publicDir, 'index.html'));
});

app.listen(port, () => {
  console.log(`Escutando na porta ${port}`);
});