export type Role = {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
};

export type Permission = {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
};

export type User = {
    id: number;
    name: string;
    email: string;
    avatar?: string | null;
    display_name?: string | null;
    phone?: string | null;
    company?: string | null;
    bio?: string | null;
    date_of_birth?: string | null;
    gender?: string | null;
    address?: string | null;
    city?: string | null;
    country?: string | null;
    timezone?: string;
    language?: string;
    social_links?: Record<string, string> | null;
    notification_preferences?: Record<string, boolean> | null;
    last_login_at?: string | null;
    last_login_ip?: string | null;
    status?: string;
    profile_photo_url?: string;
    profile_completion?: number;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    roles?: Role[];
    permissions?: Permission[];
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};

export type TwoFactorConfigContent = {
    title: string;
    description: string;
    buttonText: string;
};
