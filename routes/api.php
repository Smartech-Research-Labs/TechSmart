<?php

use App\Http\Controllers\Api\{
    AuthController,
    SocialAuthController,
    HomeController,
    ServiceController,
    ProductController,
    BundleController,
    FaqController,
    ReviewController,
    EnquiryController,
    NewsletterController,
    AIController,
    BlogController,
    CaseStudyController,
    IndustryController,
    PackageController,
    CookieConsentController
};
use App\Http\Controllers\Api\User\{
    DashboardController,
    WishlistController,
    ChatController,
    DirectMessageController,
    ProfileController
};
use App\Http\Controllers\Api\Admin\{
    CMSController,
    SettingController,
    MediaController,
    MediaLibraryController,
    BlogController as AdminBlogController,
    AiBlogController,
    PageController as AdminPageController,
    AdminReviewController,
    AdminEnquiryController,
    AdminUserController,
    AdminRoleController,
    AdminBundleController,
    AdminDashboardController,
    AdminChatController,
    AdminCaseStudyController,
    IndustryController as AdminIndustryController,
    AdminClientController,
    TrashController,
    SearchController,
    SeoDataController,
    SeoManagementController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// AYRank blog publishing (authenticated by its signature)
Route::post('/ayrank', \App\Http\Controllers\Api\AyrankWebhookController::class)->middleware('throttle:120,1');

// Public API Routes
Route::prefix('v1')->group(function () {

    // ──── Authentication ────
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
        Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');

        // Email Two-Factor Authentication
        Route::post('/2fa/verify', [AuthController::class, 'verifyTwoFactorEmail'])->middleware('throttle:5,1');
        Route::post('/2fa/resend', [AuthController::class, 'resendTwoFactorEmail'])->middleware('throttle:3,1');

        // Google OAuth
        Route::get('/google/redirect', [SocialAuthController::class, 'redirectToGoogle']);
        Route::get('/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/user', [AuthController::class, 'user']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/2fa/toggle', [AuthController::class, 'toggleTwoFactorEmail']);
        });
    });

    // ──── Homepage Data ────
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/home/faqs', [HomeController::class, 'faqs']);
    Route::get('/home/team', [HomeController::class, 'team']);
    Route::get('/home/map-data', [HomeController::class, 'mapData']);
    
    // ──── Services ────
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/category/{category}', [ServiceController::class, 'byCategory']);
    Route::get('/services/{slug}', [ServiceController::class, 'show']);
    
    // ──── Products ────
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/categories', [ProductController::class, 'categories']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);
    
    // ──── Bundles ────
    Route::get('/bundles', [BundleController::class, 'index']);
    Route::get('/bundles/{slug}', [BundleController::class, 'show']);
    
    // ──── Packages ────
    Route::get('/packages', [PackageController::class, 'index']);
    Route::get('/packages/{slug}', [PackageController::class, 'show']);
    
    // ──── FAQs ────
    Route::get('/faqs', [FaqController::class, 'index']);
    Route::get('/faqs/search', [FaqController::class, 'search']);
    
    // ──── Reviews ────
    Route::get('/reviews', [ReviewController::class, 'latest']);
    Route::get('/reviews/{type}/{id}',[ReviewController::class, 'index']);
    Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth:sanctum');
    
    // ──── Enquiries ────
    Route::post('/enquiries', [EnquiryController::class, 'store']);
    
    // ──── Newsletter ────
    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe']);
    Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe']);

    // ──── Cookie Consent ────
    Route::post('/cookies/consent', [CookieConsentController::class, 'saveConsent']);
    Route::get('/cookies/consent', [CookieConsentController::class, 'getConsent']);
    Route::post('/cookies/revoke', [CookieConsentController::class, 'revokeConsent']);

    // ──── Public Blog ────
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/categories', [BlogController::class, 'categories']);
    Route::get('/blogs/{slug}', [BlogController::class, 'show']);

    // ──── Case Studies ────
    Route::get('/case-studies', [CaseStudyController::class, 'index']);
    Route::get('/case-studies/{slug}', [CaseStudyController::class, 'show']);

    // ──── Industries ────
    Route::get('/industries', [IndustryController::class, 'index']);
    Route::get('/industries/{industry}', [IndustryController::class, 'show']);

    // ──── Public Settings ────
    Route::get('/settings', [SettingController::class, 'publicSettings']);

    // ──── Pages (Dynamic Pages) ────
    Route::get('/pages/{slug}', [AdminPageController::class, 'showBySlug']);
    
    // ──── SEO Data (Public) ────
    Route::get('/seo/resolve', [\App\Http\Controllers\SpaController::class, 'pageSeo']);
    Route::get('/seo/page/{pageName}', [SeoDataController::class, 'getByPageName']);
    
    // ──── User Dashboard Routes (Protected) ────
    Route::middleware('auth:sanctum')->prefix('user')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/enquiries', [DashboardController::class, 'enquiries']);
        Route::get('/reviews', [DashboardController::class, 'reviews']);
        Route::get('/profile', [DashboardController::class, 'profile']);
        Route::put('/profile', [DashboardController::class, 'profile']);
        Route::put('/password', [DashboardController::class, 'changePassword']);
        
        // Enhanced Profile
        Route::get('/profile/full', [ProfileController::class, 'show']);
        Route::put('/profile/full', [ProfileController::class, 'update']);
        Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar']);
        Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar']);
        Route::get('/profile/sessions', [ProfileController::class, 'sessions']);
        Route::get('/profile/activity', [ProfileController::class, 'activityLog']);
        
        // Wishlist
        Route::get('/wishlist', [WishlistController::class, 'index']);
        Route::post('/wishlist', [WishlistController::class, 'store']);
        Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);
        
        // Chat
        Route::get('/chat/sessions', [ChatController::class, 'sessions']);
        Route::post('/chat/messages', [ChatController::class, 'store']);
        Route::get('/chat/sessions/{sessionId}/messages', [ChatController::class, 'messages']);

        // Direct Messages (User-to-User)
        Route::get('/dm/conversations', [DirectMessageController::class, 'conversations']);
        Route::get('/dm/conversations/{conversation}/messages', [DirectMessageController::class, 'messages']);
        Route::post('/dm/send', [DirectMessageController::class, 'send']);
        Route::post('/dm/conversations/{conversation}/read', [DirectMessageController::class, 'markRead']);
        Route::get('/dm/users/online', [DirectMessageController::class, 'onlineUsers']);
        Route::post('/dm/presence', [DirectMessageController::class, 'updatePresence']);
    });
    
    // ──── Admin Routes (Protected) ────
    Route::middleware(['auth:sanctum', 'role:admin|superadmin'])->prefix('admin')->group(function () {
        // AI
        Route::post('/ai/generate-content', [AIController::class, 'generateContent']);
        Route::post('/ai/generate-seo', [AIController::class, 'generateSEO']);
        Route::post('/ai/analyze-sentiment', [AIController::class, 'analyzeSentiment']);
        Route::post('/ai/chatbot', [AIController::class, 'chatbot']);
        Route::post('/ai/generate-steps', [AIController::class, 'generateSteps']);
        Route::post('/ai/improve-text', [AIController::class, 'improveText']);

        // CMS (Sliders, Services, Products, Clients, Counters)
        Route::get('/sliders', [CMSController::class, 'sliders']);
        Route::post('/sliders', [CMSController::class, 'storeSlider']);
        Route::put('/sliders/{slider}', [CMSController::class, 'updateSlider']);
        Route::delete('/sliders/{slider}', [CMSController::class, 'destroySlider']);

        Route::get('/cms/services', [CMSController::class, 'services']);
        Route::post('/cms/services', [CMSController::class, 'storeService']);
        Route::put('/cms/services/{service}', [CMSController::class, 'updateService']);
        Route::delete('/cms/services/{service}', [CMSController::class, 'destroyService']);

        Route::get('/cms/products', [CMSController::class, 'products']);
        Route::post('/cms/products', [CMSController::class, 'storeProduct']);
        Route::put('/cms/products/{product}', [CMSController::class, 'updateProduct']);
        Route::delete('/cms/products/{product}', [CMSController::class, 'destroyProduct']);

        Route::get('/cms/clients', [CMSController::class, 'clients']);
        Route::post('/cms/clients', [CMSController::class, 'storeClient']);
        Route::put('/cms/clients/{client}', [CMSController::class, 'updateClient']);
        Route::delete('/cms/clients/{client}', [CMSController::class, 'destroyClient']);

        // Client Management (with image, domain, caption support)
        Route::get('/clients', [AdminClientController::class, 'index']);
        Route::post('/clients', [AdminClientController::class, 'store']);
        Route::get('/clients/{client}', [AdminClientController::class, 'show']);
        Route::put('/clients/{client}', [AdminClientController::class, 'update']);
        Route::delete('/clients/{client}', [AdminClientController::class, 'destroy']);
        Route::post('/clients/{id}/restore', [AdminClientController::class, 'restore']);

        Route::get('/cms/counters', [CMSController::class, 'counters']);
        Route::post('/cms/counters', [CMSController::class, 'storeCounter']);
        Route::put('/cms/counters/{counter}', [CMSController::class, 'updateCounter']);
        Route::delete('/cms/counters/{counter}', [CMSController::class, 'destroyCounter']);

        // Settings
        Route::get('/settings', [SettingController::class, 'index']);
        Route::put('/settings', [SettingController::class, 'update']);
        Route::post('/settings/logo', [SettingController::class, 'uploadLogo']);
        Route::post('/settings/footer-logo', [SettingController::class, 'uploadFooterLogo']);
        Route::post('/settings/favicon', [SettingController::class, 'uploadFavicon']);

        // Media Gallery
        Route::get('/media', [MediaController::class, 'index']);
        Route::post('/media/upload', [MediaController::class, 'upload']);
        Route::post('/media/upload-multiple', [MediaController::class, 'uploadMultiple']);
        Route::delete('/media', [MediaController::class, 'destroy']);
        Route::post('/media/delete-multiple', [MediaController::class, 'destroyMultiple']);

        // Media Library (with SEO metadata)
        Route::prefix('media-library')->group(function () {
            Route::get('/', [MediaLibraryController::class, 'index']);
            Route::get('/stats', [MediaLibraryController::class, 'getFolderStats']);
            Route::post('/scan-import', [MediaLibraryController::class, 'scanAndImport']);
            Route::get('/{mediaLibrary}', [MediaLibraryController::class, 'show']);
            Route::put('/{mediaLibrary}', [MediaLibraryController::class, 'update']);
            Route::delete('/{mediaLibrary}', [MediaLibraryController::class, 'destroy']);
            
            // SEO Metadata Generation
            Route::post('/{mediaLibrary}/generate-seo', [MediaLibraryController::class, 'generateSeoMetadata']);
            Route::post('/bulk-update', [MediaLibraryController::class, 'bulkUpdate']);
            Route::post('/bulk-generate-seo', [MediaLibraryController::class, 'bulkGenerateSeoMetadata']);
        });

        // Blog Management
        Route::get('/blogs', [AdminBlogController::class, 'index']);
        Route::post('/blogs', [AdminBlogController::class, 'store']);
        Route::get('/blogs/{blog}', [AdminBlogController::class, 'show']);
        Route::put('/blogs/{blog}', [AdminBlogController::class, 'update']);
        Route::delete('/blogs/{blog}', [AdminBlogController::class, 'destroy']);

        // AI Blog Automation
        Route::get('/ai-blog/status', [AiBlogController::class, 'status']);
        Route::post('/ai-blog/toggle', [AiBlogController::class, 'toggle']);
        Route::post('/ai-blog/generate-now', [AiBlogController::class, 'generateNow']);

        // Page Management
        Route::get('/pages', [AdminPageController::class, 'index']);
        Route::post('/pages', [AdminPageController::class, 'store']);
        Route::get('/pages/{page}', [AdminPageController::class, 'show']);
        Route::put('/pages/{page}', [AdminPageController::class, 'update']);
        Route::delete('/pages/{page}', [AdminPageController::class, 'destroy']);
        Route::post('/pages/{page}/sections', [AdminPageController::class, 'addSection']);
        Route::put('/sections/{section}', [AdminPageController::class, 'updateSection']);
        Route::delete('/sections/{section}', [AdminPageController::class, 'destroySection']);
        Route::post('/pages/{page}/reorder', [AdminPageController::class, 'reorderSections']);

        // Dashboard Stats
        Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats']);
        Route::get('/dashboard/activity', [AdminDashboardController::class, 'recentActivity']);
        Route::get('/dashboard/overview', [AdminDashboardController::class, 'overview']);

        // Global Search
        Route::get('/search', [SearchController::class, 'search']);
        Route::get('/search/suggestions', [SearchController::class, 'suggestions']);

        // Notifications
        Route::get('/notifications', [AdminDashboardController::class, 'notifications']);
        Route::post('/notifications/{id}/read', [AdminDashboardController::class, 'markNotificationRead']);
        Route::post('/notifications/{id}/unread', [AdminDashboardController::class, 'markNotificationUnread']);
        Route::post('/notifications/read-all', [AdminDashboardController::class, 'markAllNotificationsRead']);
        Route::delete('/notifications/{id}', [AdminDashboardController::class, 'deleteNotification']);
        Route::delete('/notifications', [AdminDashboardController::class, 'deleteAllNotifications']);

        // Reviews
        Route::get('/reviews', [AdminReviewController::class, 'index']);
        Route::get('/reviews/stats', [AdminReviewController::class, 'stats']);
        Route::put('/reviews/{review}', [AdminReviewController::class, 'update']);
        Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve']);
        Route::post('/reviews/{review}/reject', [AdminReviewController::class, 'reject']);
        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy']);

        // Enquiries
        Route::get('/enquiries', [AdminEnquiryController::class, 'index']);
        Route::get('/enquiries/stats', [AdminEnquiryController::class, 'stats']);
        Route::get('/enquiries/{enquiry}', [AdminEnquiryController::class, 'show']);
        Route::put('/enquiries/{enquiry}', [AdminEnquiryController::class, 'update']);
        Route::post('/enquiries/{enquiry}/reply', [AdminEnquiryController::class, 'reply']);
        Route::delete('/enquiries/{enquiry}', [AdminEnquiryController::class, 'destroy']);

        // Bundles
        Route::get('/bundles', [AdminBundleController::class, 'index']);
        Route::post('/bundles', [AdminBundleController::class, 'store']);
        Route::put('/bundles/{bundle}', [AdminBundleController::class, 'update']);
        Route::delete('/bundles/{bundle}', [AdminBundleController::class, 'destroy']);

        // Packages
        Route::get('/packages', [PackageController::class, 'adminIndex']);
        Route::post('/packages', [PackageController::class, 'store']);
        Route::put('/packages/{package}', [PackageController::class, 'update']);
        Route::delete('/packages/{package}', [PackageController::class, 'destroy']);
        Route::post('/packages/{package}/restore', [PackageController::class, 'restore']);
        Route::post('/packages/{package}/features', [PackageController::class, 'addFeature']);
        Route::put('/packages/{package}/features/{feature}', [PackageController::class, 'updateFeature']);
        Route::delete('/packages/{package}/features/{feature}', [PackageController::class, 'deleteFeature']);

        // Chat (Admin)
        Route::get('/chat/sessions', [AdminChatController::class, 'sessions']);
        Route::get('/chat/sessions/{session}/messages', [AdminChatController::class, 'messages']);
        Route::post('/chat/sessions/{session}/reply', [AdminChatController::class, 'reply']);
        Route::post('/chat/sessions/{session}/close', [AdminChatController::class, 'closeSession']);
        Route::get('/chat/stats', [AdminChatController::class, 'stats']);
        Route::get('/chat/metrics', [AdminChatController::class, 'metrics']);

        // Case Studies
        Route::get('/case-studies', [AdminCaseStudyController::class, 'index']);
        Route::post('/case-studies', [AdminCaseStudyController::class, 'store']);
        Route::get('/case-studies/{caseStudy}', [AdminCaseStudyController::class, 'show']);
        Route::put('/case-studies/{caseStudy}', [AdminCaseStudyController::class, 'update']);
        Route::delete('/case-studies/{caseStudy}', [AdminCaseStudyController::class, 'destroy']);

        // Industries
        Route::get('/industries', [AdminIndustryController::class, 'index']);
        Route::post('/industries', [AdminIndustryController::class, 'store']);
        Route::get('/industries/{industry}', [AdminIndustryController::class, 'show']);
        Route::put('/industries/{industry}', [AdminIndustryController::class, 'update']);
        Route::delete('/industries/{industry}', [AdminIndustryController::class, 'destroy']);

        // Users & Roles (SuperAdmin)
        Route::get('/users', [AdminUserController::class, 'index']);
        Route::get('/users/stats', [AdminUserController::class, 'stats']);
        Route::post('/users', [AdminUserController::class, 'store']);
        Route::put('/users/{user}', [AdminUserController::class, 'update']);
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy']);

        Route::get('/roles', [AdminRoleController::class, 'index']);
        Route::get('/permissions', [AdminRoleController::class, 'permissions']);
        Route::post('/roles', [AdminRoleController::class, 'store']);
        Route::put('/roles/{role}', [AdminRoleController::class, 'update']);
        Route::delete('/roles/{role}', [AdminRoleController::class, 'destroy']);

        // Trash Management (soft-deleted items)
        Route::get('/trash/{type}', [TrashController::class, 'index']);
        Route::post('/trash/{type}/{id}/restore', [TrashController::class, 'restore']);
        Route::delete('/trash/{type}/{id}', [TrashController::class, 'forceDelete']);
        Route::post('/trash/{type}/restore-all', [TrashController::class, 'restoreAll']);

        // SEO Management
        Route::get('/seo', [SeoManagementController::class, 'index']);
        Route::post('/seo', [SeoManagementController::class, 'store']);
        Route::get('/seo/{seoData}', [SeoManagementController::class, 'show']);
        Route::put('/seo/{seoData}', [SeoManagementController::class, 'update']);
        Route::delete('/seo/{seoData}', [SeoManagementController::class, 'destroy']);
        Route::post('/seo/preview', [SeoManagementController::class, 'preview']);
        Route::post('/seo/bulk-update', [SeoManagementController::class, 'bulkUpdate']);
        Route::get('/seo/audit/report', [SeoManagementController::class, 'getAudit']);
        Route::get('/seo/tracking/config', [SeoManagementController::class, 'trackingConfig']);
        Route::get('/seo/analytics/data', [SeoManagementController::class, 'analyticsData']);
        Route::post('/seo/search-console/submit', [SeoManagementController::class, 'submitToSearchConsole']);

        // Previous SEO routes (kept for compatibility)
        Route::get('/seo/page/{pageName}', [SeoDataController::class, 'getByPageName']);

        // Cookie Consent Analytics & Management
        Route::get('/cookies/analytics', [CookieConsentController::class, 'getAnalytics']);
        Route::get('/cookies/marketing-emails', [CookieConsentController::class, 'getMarketingEmails']);
    });
});

