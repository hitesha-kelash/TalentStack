"use client";

import { useState } from "react";
import Link from "next/link";
import { Eye, EyeOff, ArrowRight } from "lucide-react";

import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Checkbox } from "@/components/ui/checkbox";

import AuthLayout from "../authlayout";
import { toast } from "sonner";

export default function SignupForm() {
  const [showPassword, setShowPassword] = useState(false);
  const [loading, setLoading] = useState(false);
  const [form, setForm] = useState({
    email: "",
    firstName: "",
    lastName: "",
    userName: "",
    password: "",
  });
  const handleSignuproute = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);

    const response = await fetch("/api/auth/signup", {
      method: "POST",
      body: JSON.stringify(form),
      headers: { "Content-Type": "application/json" },
    });
    await response.json();
    if (!response.ok) {
      toast.error("Error Signin up");
      setLoading(false);
    }
    if (response.ok) {
      toast.success("Hurray 🎉 Signed Up, Please verify Your Email to log in");
      setLoading(false);
    }
  };
  return (
    <AuthLayout>
      <div className="w-full max-w-md mx-auto p-6 space-y-6 bg-black/40 backdrop-blur-sm rounded-xl border border-purple-500/20">
        <div className="space-y-2 text-center">
          <h1 className="text-2xl font-bold tracking-tight text-white">
            Join FreeFlow
          </h1>
          <p className="text-sm text-zinc-400">
            Enter your information to get started
          </p>
        </div>
        <div className="space-y-4">
          <div className="grid grid-cols-2 gap-4">
            <div className="space-y-2">
              <Label htmlFor="first-name" className="text-zinc-300">
                First name
              </Label>
              <Input
                value={form.firstName}
                id="first-name"
                placeholder="Ankit"
                onChange={(e) =>
                  setForm({ ...form, firstName: e.target.value })
                }
                className="bg-zinc-900 border-zinc-800 text-white placeholder:text-zinc-500 focus-visible:ring-purple-500"
              />
            </div>
            <div className="space-y-2">
              <Label htmlFor="last-name" className="text-zinc-300">
                Last name
              </Label>
              <Input
                value={form.lastName}
                id="last-name"
                placeholder="Mishra"
                onChange={(e) => setForm({ ...form, lastName: e.target.value })}
                className="bg-zinc-900 border-zinc-800 text-white placeholder:text-zinc-500 focus-visible:ring-purple-500"
              />
            </div>
          </div>
          <div className="space-y-2">
            <Label htmlFor="username" className="text-zinc-300">
              Username
            </Label>
            <Input
              value={form.userName}
              id="username"
              placeholder="ankitmishra08"
              type="text"
              onChange={(e) => setForm({ ...form, userName: e.target.value })}
              className="bg-zinc-900 border-zinc-800 text-white placeholder:text-zinc-500 focus-visible:ring-purple-500"
            />
          </div>
          <div className="space-y-2">
            <Label htmlFor="email" className="text-zinc-300">
              Email
            </Label>
            <Input
              value={form.email}
              id="email"
              onChange={(e) => setForm({ ...form, email: e.target.value })}
              placeholder="name@example.com"
              type="email"
              className="bg-zinc-900 border-zinc-800 text-white placeholder:text-zinc-500 focus-visible:ring-purple-500"
            />
          </div>
          <div className="space-y-2">
            <Label htmlFor="password" className="text-zinc-300">
              Password
            </Label>
            <div className="relative">
              <Input
                value={form.password}
                onChange={(e) => setForm({ ...form, password: e.target.value })}
                id="password"
                type={showPassword ? "text" : "password"}
                placeholder="••••••••"
                className="bg-zinc-900 border-zinc-800 text-white placeholder:text-zinc-500 focus-visible:ring-purple-500"
              />
              <Button
                type="button"
                variant="ghost"
                size="icon"
                className="absolute right-2 top-1/2 -translate-y-1/2 h-7 w-7 text-zinc-400 hover:text-white hover:bg-zinc-800"
                onClick={() => setShowPassword(!showPassword)}
              >
                {showPassword ? (
                  <EyeOff className="h-4 w-4" />
                ) : (
                  <Eye className="h-4 w-4" />
                )}
                <span className="sr-only">
                  {showPassword ? "Hide password" : "Show password"}
                </span>
              </Button>
            </div>
            <p className="text-xs text-zinc-500">
              Must be at least 8 characters
            </p>
          </div>
          <div className="flex items-start space-x-2">
            <Checkbox
              id="terms"
              className="border-zinc-700 data-[state=checked]:bg-purple-500 data-[state=checked]:border-purple-500 mt-1"
            />
            <label
              htmlFor="terms"
              className="text-sm leading-none text-zinc-400"
            >
              I agree to the{" "}
              <Link
                href="/terms"
                className="text-purple-400 hover:text-purple-300"
              >
                Terms of Service
              </Link>{" "}
              and{" "}
              <Link
                href="/privacy"
                className="text-purple-400 hover:text-purple-300"
              >
                Privacy Policy
              </Link>
            </label>
          </div>
          {loading ? (
            <Button
              disabled
              className="w-full bg-purple-600 hover:bg-purple-700 text-white"
            >
              Creating Account please wait
              <ArrowRight className="ml-2 h-4 w-4" />
            </Button>
          ) : (
            <Button
              onClick={handleSignuproute}
              className="w-full bg-purple-600 hover:bg-purple-700 text-white"
            >
              Sign Up
              <ArrowRight className="ml-2 h-4 w-4" />
            </Button>
          )}
        </div>

        <div className="text-center text-sm text-zinc-400">
          Already have an account?{" "}
          <Link href="/login" className="text-purple-400 hover:text-purple-300">
            Sign in
          </Link>
        </div>
      </div>
    </AuthLayout>
  );
}
