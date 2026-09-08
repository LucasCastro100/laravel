import AuthLayoutTemplate from '@/layouts/auth/auth-simple-layout';

export default function AuthLayout({
    title = '',
    description = '',
    brand = false,
    children,
}: {
    title?: string;
    description?: string;
    brand?: boolean;
    children: React.ReactNode;
}) {
    return (
        <AuthLayoutTemplate
            title={title}
            description={description}
            brand={brand}
        >
            {children}
        </AuthLayoutTemplate>
    );
}
