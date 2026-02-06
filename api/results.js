export default function handler(req, res) {
  res.setHeader("Content-Type", "application/json");
  res.setHeader("Access-Control-Allow-Origin", "*");

  const { keyid, key } = req.query;

  if (!keyid || !key) {
    return res.status(400).json({ error: true, msg: "Missing keyid or key" });
  }

  // تحويل HEX → BASE64
  function hexToBase64(hex) {
    return Buffer.from(hex, "hex").toString("base64").replace(/\+/g, "-").replace(/\//g, "_").replace(/=+$/, "");
  }

  const kid_b64 = hexToBase64(keyid);
  const key_b64 = hexToBase64(key);

  res.status(200).json({
    keys: [
      {
        kty: "oct",
        kid: kid_b64,
        k: key_b64
      }
    ],
    type: "temporary"
  });
}
