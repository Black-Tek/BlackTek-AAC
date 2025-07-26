import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';

type CompleteSocialiteForm = {
    account_name: string;
    password: string;
    password_confirmation: string;
};

interface SocialiteData {
    provider: string;
    provider_id: string;
    nickname: string;
    email: string;
    avatar: string | null;
    token: string;
}

interface CompleteSocialiteProps {
    socialiteData: SocialiteData;
}

export default function CompleteSocialite({ socialiteData }: CompleteSocialiteProps) {
    const { data, setData, post, processing, errors, reset } = useForm<CompleteSocialiteForm>({
        account_name: '',
        password: '',
        password_confirmation: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('auth.socialite.complete.store'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <AuthLayout title="Complete registration" description="Finish your registration with game account details">
            <Head title="Complete registration" />

            <div className="w-full max-w-md">
                <div className="mb-6 text-center">
                    <p className="mt-2 text-gray-600 dark:text-gray-400">
                        Hello {socialiteData.nickname}! To complete your registration we need some additional details for your game account.
                    </p>
                </div>

                {socialiteData.avatar && (
                    <div className="mb-6 text-center">
                        <img src={socialiteData.avatar} alt="Avatar" className="mx-auto h-16 w-16 rounded-full object-cover" />
                    </div>
                )}

                <form onSubmit={submit} className="space-y-4">
                    {/* Account Name */}
                    <div>
                        <Label htmlFor="account_name">Account name (for game)</Label>
                        <Input
                            id="account_name"
                            type="text"
                            name="account_name"
                            value={data.account_name}
                            className="mt-1 block w-full"
                            autoComplete="username"
                            autoFocus
                            onChange={(e) => setData('account_name', e.target.value)}
                            required
                        />
                        <p className="mt-1 text-sm text-gray-500">This will be your account name in the game</p>
                        <InputError message={errors.account_name} className="mt-2" />
                    </div>

                    <div>
                        <Label htmlFor="password">Password (for game)</Label>
                        <Input
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className="mt-1 block w-full"
                            autoComplete="new-password"
                            onChange={(e) => setData('password', e.target.value)}
                            required
                        />
                        <p className="mt-1 text-sm text-gray-500">This password will be used to login to the game</p>
                        <InputError message={errors.password} className="mt-2" />
                    </div>

                    <div>
                        <Label htmlFor="password_confirmation">Confirm password</Label>
                        <Input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            value={data.password_confirmation}
                            className="mt-1 block w-full"
                            autoComplete="new-password"
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            required
                        />
                        <InputError message={errors.password_confirmation} className="mt-2" />
                    </div>

                    <div className="flex items-center justify-between pt-4">
                        <TextLink href={route('login')} className="text-sm">
                            Change account?
                        </TextLink>

                        <Button className="ml-4" disabled={processing}>
                            {processing && <LoaderCircle className="animate-spin" />}
                            Complete registration
                        </Button>
                    </div>
                </form>
            </div>
        </AuthLayout>
    );
}
