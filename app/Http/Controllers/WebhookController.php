<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Validate the webhook signature (if using a secret)
        $secret = config('services.github.webhook_secret'); // Add this to your services config file
        $signature = $request->header('X-Hub-Signature') ?? '';

        if (!$this->isValidSignature($request->getContent(), $signature, $secret)) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Handle the event
        $event = $request->header('X-GitHub-Event');
        $payload = $request->all();

        switch ($event) {
            case 'push':
                $this->handlePushEvent($payload);
                break;

            default:
                return response()->json(['message' => 'Event not handled'], 200);
        }

        return response()->json(['message' => 'Webhook handled'], 200);
    }

    private function isValidSignature($payload, $signature, $secret)
    {
        $hash = 'sha1=' . hash_hmac('sha1', $payload, $secret);
        return hash_equals($hash, $signature);
    }

    private function handlePushEvent($payload)
    {
        // Execute your deployment commands here
        $commands = [
            'cd /home/offerlooto/public_html', // Update to your deployment path
            'git reset --hard',
            'git pull origin master', // Change 'main' to your default branch
            'composer install --no-dev',
            'php artisan migrate --force',
            'php artisan cache:clear',
        ];

        foreach ($commands as $command) {
            shell_exec($command);
        }
    }
}
