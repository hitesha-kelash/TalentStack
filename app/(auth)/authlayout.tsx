import type { ReactNode } from "react";
import Link from "next/link";
import { Check, Flower } from "lucide-react";

interface AuthLayoutProps {
  children: ReactNode;
  title?: string;
  description?: string;
}

export default function AuthLayout({
  children,
  title = "FreeFlow for Creatives",
  description = "The all-in-one platform for freelancers to showcase work, manage clients, and get paid seamlessly.",
}: AuthLayoutProps) {
  return (
    <div className="sm:min-h-screen bg-black text-white">
      <div className="flex sm:min-h-screen flex-col md:flex-row">
        {/* Left side - Description */}
        <div className="w-full lg:w-1/2 bg-gradient-to-br from-black via-zinc-900 to-black p-6 md:p-10 lg:p-16 md:flex flex-col hidden">
          <div className="logo flex justify-start align-middle items-center">
            <Link
              className="flex justify-center align-middle items-center gap-2"
              href={"/"}
            >
              <Flower className="" size={40} color="#b78bf2" />{" "}
              <span className="text-high text-2xl">FreeFlow</span>
            </Link>
          </div>

          <div className="flex-1 flex flex-col justify-center max-w-md mx-auto lg:mx-0">
            <h1 className="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6">
              {title}
            </h1>
            <p className="text-zinc-400 text-lg mb-8">{description}</p>

            <div className="space-y-4 mb-8">
              <FeatureItem>
                Showcase your portfolio with beautiful templates
              </FeatureItem>
              <FeatureItem>
                Track time and manage projects efficiently
              </FeatureItem>
              <FeatureItem>Create and send professional invoices</FeatureItem>
              <FeatureItem>
                Get paid faster with integrated payment options
              </FeatureItem>
            </div>
          </div>

          <div className="mt-8 pt-8 border-t border-zinc-800 hidden lg:block">
            <div className="flex items-center justify-between text-sm text-zinc-500">
              <div className="flex space-x-4">
                <Link href="#" className="hover:text-white transition-colors">
                  Terms
                </Link>
                <Link href="#" className="hover:text-white transition-colors">
                  Privacy
                </Link>
                <Link href="#" className="hover:text-white transition-colors">
                  Contact
                </Link>
              </div>
              <div>© {new Date().getFullYear()} FreeFlow</div>
            </div>
          </div>
        </div>

        {/* Right side - Auth Form */}
        <div className="w-full lg:w-1/2 bg-zinc-950 flex items-center justify-center h-screen p-6 md:p-10 lg:p-16">
          <div className="w-full">{children}</div>
        </div>
      </div>
    </div>
  );
}

function FeatureItem({ children }: { children: React.ReactNode }) {
  return (
    <div className="flex items-start">
      <div className="flex-shrink-0 h-6 w-6 rounded-full bg-purple-500/20 flex items-center justify-center mt-0.5">
        <Check className="h-3.5 w-3.5 text-purple-400" />
      </div>
      <p className="ml-3 text-zinc-300">{children}</p>
    </div>
  );
}
