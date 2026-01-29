const express = require('express');
const session = require('express-session');
const passport = require('passport');
const GoogleStrategy = require('passport-google-oauth20').Strategy;
const mysql = require('mysql2/promise');

const app = express();

// ===== DATABASE CONNECTION =====
const db = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: 'password',      // change to your DB password
    database: 'grading_system' // name of your database
});

// ===== SESSION SETUP =====
app.use(session({ secret: 'supersecret', resave: false, saveUninitialized: true }));
app.use(passport.initialize());
app.use(passport.session());

// ===== PASSPORT SERIALIZE/DESERIALIZE =====
passport.serializeUser((user, done) => done(null, user.id));
passport.deserializeUser(async (id, done) => {
    try {
        const [rows] = await db.query('SELECT * FROM users WHERE id = ?', [id]);
        done(null, rows[0]);
    } catch (err) {
        done(err, null);
    }
});

// ===== GOOGLE OAUTH STRATEGY =====
passport.use(new GoogleStrategy({
    clientID: 'YOUR_GOOGLE_CLIENT_ID',        // replace with your Google API credentials
    clientSecret: 'YOUR_GOOGLE_CLIENT_SECRET',
    callbackURL: 'http://localhost:3000/auth/google/callback'
}, async (accessToken, refreshToken, profile, done) => {
    try {
        const email = profile.emails[0].value;

        // Check if user exists by Google ID or email
        const [rows] = await db.query('SELECT * FROM users WHERE google_id = ? OR email = ?', [profile.id, email]);

        if (rows.length > 0) {
            // User exists, update google_id if blank
            const user = rows[0];
            if (!user.google_id) {
                await db.query('UPDATE users SET google_id = ? WHERE id = ?', [profile.id, user.id]);
            }
            return done(null, { ...user, google_id: profile.id });
        }

        // New user, assign role automatically (default = student)
        let role = 'student';
        if (email.startsWith('teacher')) role = 'teacher';
        if (email.startsWith('admin')) role = 'admin';

        const [result] = await db.query(
            'INSERT INTO users (google_id, email, name, role) VALUES (?, ?, ?, ?)',
            [profile.id, email, profile.displayName, role]
        );

        const newUser = { id: result.insertId, google_id: profile.id, email, name: profile.displayName, role };
        return done(null, newUser);

    } catch (err) {
        console.error(err);
        return done(err, null);
    }
}));

// ===== ROUTES =====

// Home page
app.get('/', (req, res) => {
    res.send('<h1>Welcome to Grading System</h1><a href="/auth/google">Sign in with Google</a>');
});

// Start Google login
app.get('/auth/google', passport.authenticate('google', { scope: ['profile', 'email'] }));

// Google callback
app.get('/auth/google/callback',
    passport.authenticate('google', { failureRedirect: '/' }),
    (req, res) => {
        res.send(`<h2>Hello ${req.user.name}</h2><p>Role: ${req.user.role}</p>`);
    }
);

// Logout
app.get('/logout', (req, res) => {
    req.logout(() => {
        res.redirect('/');
    });
});

// ===== SERVER START =====
app.listen(3000, () => console.log('Server running on http://localhost:3000'));
