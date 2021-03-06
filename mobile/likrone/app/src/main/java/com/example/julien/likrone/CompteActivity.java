package com.example.julien.likrone;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.concurrent.ExecutionException;

public class CompteActivity extends MenuActivity {

    public CompteActivity() {
        super(3);
    }


    final String EXTRA_User = "info login";
    String json = null;
    final String EXTRA_PSEUDO = "Id User";
    ImageView avatar = null;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.compte);

        Intent intent = getIntent();
        TextView idUser = (TextView) findViewById(R.id.viewId);
        TextView nomUser = (TextView) findViewById(R.id.viewName);
        TextView mailUser = (TextView) findViewById(R.id.viewMail);
        avatar = (ImageView) findViewById(R.id.avatar);

        // On transforme le String obtenu en Json pour pouvoir le parse

        json = intent.getStringExtra(EXTRA_User).toString();
        try {
            JSONObject obj = new JSONObject(json);
            String id=obj.getString("id");
            idUser.setText(id);
            nomUser.setText(obj.getString("username"));
            intent.putExtra("pseudo", nomUser.getText().toString());
            mailUser.setText(obj.getString("email"));
            avatar.setImageBitmap(new getAvatar().execute(id).get());
        } catch (JSONException e) {
            e.printStackTrace();
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        }
    }

    private class getAvatar extends AsyncTask<String, Void, Bitmap> {
        Bitmap bitmap = null;

        @Override
        protected Bitmap doInBackground(String... params) {
            try {
                URL urlImage = new URL("http://api-rest-youcef-m.c9.io/avatar/" + params[0] + ".jpg");
                HttpURLConnection connection = (HttpURLConnection) urlImage.openConnection();
                connection.setRequestMethod("GET");
                InputStream inputStream = connection.getInputStream();
                bitmap = BitmapFactory.decodeStream(inputStream);
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return bitmap;
        }
    }
}