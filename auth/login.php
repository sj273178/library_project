<?php
session_start();

include '../index.php';
if (!empty($_SESSION['user_id'])) {
	header('Location: ../index.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#176b5b">
	<title>Sign in | The Reading Room</title>
	<style>
		:root {
			/* Uses the site's theme variable when available; otherwise falls back to its library-green palette. */
			--brand: var(--theme-color, var(--green, #176b5b));
			--brand-dark: #104c42;
			--ink: #1d2b28;
			--muted: #71807b;
			--paper: #fffefa;
			--line: #e4e9e5;
		}

		* { box-sizing: border-box; }

		body {
			min-height: 100vh;
			margin: 0;
			display: grid;
			place-items: center;
			padding: 32px 20px;
			color: var(--ink);
			background: #f3f5ef;
			font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
		}

		.login-shell {
			width: min(100%, 980px);
			min-height: 590px;
			display: grid;
			grid-template-columns: 1fr 1fr;
			overflow: hidden;
			border: 1px solid rgba(29, 43, 40, .07);
			border-radius: 24px;
			background: var(--paper);
			box-shadow: 0 24px 70px rgba(27, 47, 39, .12);
		}

		.welcome-panel {
			position: relative;
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			overflow: hidden;
			padding: 42px;
			color: #fff;
			background: var(--brand);
		}

		.welcome-panel::before,
		.welcome-panel::after {
			position: absolute;
			content: "";
			border: 1px solid rgba(255, 255, 255, .13);
			border-radius: 50%;
			pointer-events: none;
		}

		.welcome-panel::before { width: 390px; height: 390px; right: -170px; top: 100px; }
		.welcome-panel::after { width: 290px; height: 290px; right: -120px; top: 150px; }

		.brand-lockup, .welcome-copy, .panel-note { position: relative; z-index: 1; }
		.brand-lockup { display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 700; letter-spacing: .02em; }
		.brand-mark {
			width: 42px;
			height: 42px;
			display: grid;
			place-items: center;
			border: 1px solid rgba(255,255,255,.32);
			border-radius: 13px;
			background: rgba(255,255,255,.12);
		}
		.brand-mark svg { width: 23px; height: 23px; }
		.welcome-copy { max-width: 370px; margin: auto 0; padding: 54px 0; }
		.eyebrow { margin: 0 0 15px; color: rgba(255,255,255,.74); font-size: 11px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
		.welcome-copy h1 { margin: 0; font-family: Georgia, "Times New Roman", serif; font-size: clamp(36px, 4vw, 52px); font-weight: 400; line-height: 1.08; letter-spacing: -.035em; }
		.welcome-copy p:last-child { max-width: 310px; margin: 20px 0 0; color: rgba(255,255,255,.8); font-size: 15px; line-height: 1.75; }
		.panel-note { margin: 0; color: rgba(255,255,255,.7); font-size: 12px; }

		.form-panel { display: flex; align-items: center; justify-content: center; padding: 54px clamp(28px, 6vw, 72px); }
		.form-content { width: 100%; max-width: 360px; }
		.form-content h2 { margin: 0 0 9px; font-family: Georgia, "Times New Roman", serif; font-size: 34px; font-weight: 400; letter-spacing: -.03em; }
		.intro { margin: 0 0 34px; color: var(--muted); font-size: 14px; line-height: 1.6; }
		.field { margin-bottom: 20px; }
		label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 650; }
		input[type="email"], input[type="password"] {
			width: 100%;
			height: 48px;
			padding: 0 14px;
			border: 1px solid var(--line);
			border-radius: 9px;
			outline: none;
			background: #fff;
			color: var(--ink);
			font: inherit;
			font-size: 14px;
			transition: border-color .2s, box-shadow .2s;
		}
		input:focus { border-color: var(--brand); box-shadow: 0 0 0 3px color-mix(in srgb, var(--brand) 13%, transparent); }
		input::placeholder { color: #a4afaa; }
		.form-options { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin: 2px 0 25px; font-size: 12px; }
		.remember { display: flex; align-items: center; gap: 8px; color: var(--muted); cursor: pointer; }
		.remember input { accent-color: var(--brand); }
		a { color: var(--brand); font-weight: 650; text-decoration: none; }
		a:hover { text-decoration: underline; }
		.submit-button {
			width: 100%;
			min-height: 49px;
			border: 0;
			border-radius: 9px;
			background: var(--brand);
			color: #fff;
			cursor: pointer;
			font: inherit;
			font-size: 14px;
			font-weight: 700;
			transition: background .2s, transform .2s;
		}
		.submit-button:hover { background: var(--brand-dark); transform: translateY(-1px); }
		.signup { margin: 24px 0 0; color: var(--muted); text-align: center; font-size: 13px; }
		.form-footnote { margin: 43px 0 0; color: #9aa49f; text-align: center; font-size: 11px; }

		@media (max-width: 700px) {
			body { padding: 16px; }
			.login-shell { max-width: 460px; min-height: 0; grid-template-columns: 1fr; border-radius: 18px; }
			.welcome-panel { min-height: 220px; padding: 25px 28px; }
			.welcome-copy { padding: 30px 0 8px; }
			.welcome-copy h1 { font-size: 36px; }
			.welcome-copy p:last-child, .panel-note { display: none; }
			.form-panel { padding: 36px 28px; }
			.form-footnote { margin-top: 30px; }
		}

		@media (prefers-reduced-motion: reduce) { *, *::before, *::after { transition-duration: .01ms !important; } }
	</style>
</head>
<body>
	<main class="login-shell">
		<section class="welcome-panel" aria-label="Welcome">
			<div class="brand-lockup">
				<span class="brand-mark" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 5.5c2.8-.9 5.4-.5 8 1.2v12c-2.6-1.7-5.2-2.1-8-1.2v-12Zm16 0c-2.8-.9-5.4-.5-8 1.2v12c2.6-1.7 5.2-2.1 8-1.2v-12Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M12 7v12" stroke="currentColor" stroke-width="1.6"/></svg>
				</span>
				<span>The Reading Room</span>
			</div>
			<div class="welcome-copy">
				<p class="eyebrow">A world of stories awaits</p>
				<h1>Your next chapter starts here.</h1>
				<p>Sign in to explore your library, keep track of your reading, and discover something wonderful.</p>
			</div>
			<p class="panel-note">A quieter place to find your next favorite.</p>
		</section>

		<section class="form-panel" aria-labelledby="login-title">
			<div class="form-content">
				<h2 id="login-title">Welcome back</h2>
				<p class="intro">Enter your details to sign in to your account.</p>
				<form action="" method="post">
					<div class="field">
						<label for="email">Email address</label>
						<input id="email" name="email" type="email" placeholder="you@example.com" autocomplete="email" required>
					</div>
					<div class="field">
						<label for="password">Password</label>
						<input id="password" name="password" type="password" placeholder="Enter your password" autocomplete="current-password" required>
					</div>
					<div class="form-options">
						<label class="remember" for="remember"><input id="remember" name="remember" type="checkbox"> Remember me</label>
						<a href="forgot-password.php">Forgot password?</a>
					</div>
					<button class="submit-button" type="submit">Sign in</button>
				</form>
				<p class="signup">New to the library? <a href="register.php">Create an account</a></p>
				<p class="form-footnote">Your library, wherever you are.</p>
			</div>
		</section>
	</main>
</body>
</html>
