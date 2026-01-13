# JWT Authentication Setup - Volunteer Management System

## Overview
JWT (JSON Web Token) authentication has been configured for securing webhook communications between n8n and the Laravel application.

## Installation Details
- **Package**: `tymon/jwt-auth` v2.2.1
- **Installation Date**: January 13, 2026
- **Dependencies**: 
  - lcobucci/jwt v4.0.4
  - lcobucci/clock v2.3.0

## Configuration

### Environment Variables
The following JWT configuration has been added to `.env`:

```env
JWT_SECRET=r24rBGBo95Ec7Ql8f537Pz6oB6kTIFT+oBVjKvVgWMUQpxVkug2A1K+nNTkg03FmizpqDDPQ0OGf4zK2jJpFJA==
JWT_TTL=60
JWT_REFRESH_TTL=20160
```

**Configuration Explanation:**
- `JWT_SECRET`: 64-byte base64-encoded secret key used to sign and verify tokens
- `JWT_TTL`: Token time-to-live in minutes (60 minutes = 1 hour)
- `JWT_REFRESH_TTL`: Refresh token validity in minutes (20160 minutes = 2 weeks)

### Config File
A new configuration file has been created at `config/jwt.php` with the following key settings:
- Algorithm: HS256 (HMAC SHA-256)
- Blacklist enabled for token invalidation
- Lock subject enabled to prevent cross-model impersonation

## Usage for n8n Webhooks

### Generating JWT Tokens
To generate a JWT token for n8n webhook authentication:

```php
use Tymon\JWTAuth\Facades\JWTAuth;

// For webhook authentication (no user context needed)
$token = JWTAuth::claims(['webhook' => true, 'source' => 'n8n'])->attempt([]);

// Or create a custom payload
$customClaims = [
    'webhook_id' => 'volunteer_assignment',
    'source' => 'n8n',
    'permissions' => ['read', 'write']
];
$token = JWTAuth::customClaims($customClaims)->fromUser($user);
```

### Verifying JWT Tokens in Webhook Endpoints
Create middleware to verify JWT tokens from n8n:

```php
// In your webhook controller
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

public function handleN8nWebhook(Request $request)
{
    try {
        // Get token from Authorization header
        $token = $request->bearerToken();
        
        // Verify and decode the token
        $payload = JWTAuth::setToken($token)->getPayload();
        
        // Validate it's from n8n
        if ($payload->get('source') !== 'n8n') {
            return response()->json(['error' => 'Invalid token source'], 401);
        }
        
        // Process webhook...
        
    } catch (JWTException $e) {
        return response()->json(['error' => 'Token validation failed'], 401);
    }
}
```

## Next Steps

### 1. Create Webhook Endpoints
Create routes and controllers for n8n webhooks:
- Volunteer assignment suggestions
- Poll vote notifications
- Chatbot message handling

### 2. Configure n8n
Add JWT token to n8n webhook configuration:
- Set Authorization header: `Bearer {your_jwt_token}`
- Configure webhook URL pointing to Laravel endpoints

### 3. Implement Middleware
Create dedicated JWT middleware for webhook routes:
```bash
php artisan make:middleware VerifyN8nWebhook
```

### 4. Security Considerations
- **Never commit** the `JWT_SECRET` to version control
- Rotate JWT secret periodically in production
- Use HTTPS for all webhook communications
- Implement rate limiting on webhook endpoints
- Log all webhook requests for auditing

## Testing JWT

### Verify Configuration
```bash
# Check if JWT secret is loaded
php artisan tinker --execute="echo config('jwt.secret');"

# Test JWT package
php artisan tinker --execute="use Tymon\JWTAuth\Facades\JWTAuth; echo 'JWT loaded';"
```

### Generate Test Token
```bash
php artisan tinker
> use Tymon\JWTAuth\Facades\JWTAuth;
> $token = JWTAuth::claims(['test' => true])->attempt([]);
> echo $token;
```

## Troubleshooting

### Issue: "JWT secret not set"
**Solution**: Ensure `JWT_SECRET` exists in `.env` and run `php artisan config:clear`

### Issue: "Token could not be parsed"
**Solution**: Verify the token format is correct and hasn't been truncated

### Issue: "Token has expired"
**Solution**: Generate a new token or increase `JWT_TTL` value

## Resources
- [tymon/jwt-auth Documentation](https://jwt-auth.readthedocs.io/en/develop/)
- [JWT.io Debugger](https://jwt.io/) - Decode and verify tokens
- [Laravel JWT Best Practices](https://laravel.com/docs/authentication)

---

**Created**: January 13, 2026  
**Last Updated**: January 13, 2026  
**Maintained By**: Development Team
