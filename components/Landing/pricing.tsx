import Link from "next/link";
import { Check } from "lucide-react";
import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

export default function PricingTeaser() {
  return (
    <section className="w-full py-12 md:py-24 lg:py-32 ">
      <div className="container px-4 md:px-6">
        <div className="flex flex-col items-center justify-center space-y-4 text-center">
          <div className="space-y-2">
            <h2 className="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl">
              Start Free, Scale When You&apos;re Ready
            </h2>
            <p className="max-w-[700px] text-gray-500 md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed mx-auto">
              Choose the plan that works for your business needs
            </p>
          </div>
        </div>
        <div className="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 md:gap-8 max-w-4xl mx-auto">
          {/* Free Tier Card */}
          <Card className="relative overflow-hidden border-2  shadow-lg transition-all hover:shadow-xl  max-h-max">
            <CardHeader className="pb-4">
              <CardTitle className="text-2xl">Free Tier</CardTitle>
              <CardDescription>Perfect for getting started</CardDescription>
              <div className="mt-1 font-bold text-4xl">$0</div>
              <div className="text-sm text-muted-foreground">forever</div>
            </CardHeader>
            <CardContent className="pb-4">
              <ul className="space-y-2 text-sm">
                <li className="flex items-center">
                  <Check className="mr-2 h-4 w-4 text-green-500" />
                  <span>Basic portfolio</span>
                </li>
                <li className="flex items-center">
                  <Check className="mr-2 h-4 w-4 text-green-500" />
                  <span>5 clients</span>
                </li>
                <li className="flex items-center">
                  <Check className="mr-2 h-4 w-4 text-green-500" />
                  <span>3 invoices/month</span>
                </li>
                <li className="flex items-center">
                  <Check className="mr-2 h-4 w-4 text-green-500" />
                  <span>Email support</span>
                </li>
              </ul>
            </CardContent>
            <CardFooter className="">
              <Button asChild className="w-full bg-white hover:bg-green-600">
                <Link href="/signup">Sign Up Now</Link>
              </Button>
            </CardFooter>
          </Card>

          {/* Premium Tier Card */}
          <Card className="border shadow-lg transition-all hover:shadow-xl relative border-blue-500 overflow-clip">
            <div className="absolute top-0 right-0 bg-blue-500 text-white px-3 py-1 text-xs font-medium">
              RECOMMENDED
            </div>
            <CardHeader className="pb-4">
              <CardTitle className="text-2xl">Premium Tier</CardTitle>
              <CardDescription>For growing businesses</CardDescription>
              <div className="mt-1 font-bold text-4xl">$9</div>
              <div className="text-sm text-muted-foreground">per month</div>
            </CardHeader>
            <CardContent className="pb-4">
              <ul className="space-y-2 text-sm">
                <li className="flex items-center">
                  <Check className="mr-2 h-4 w-4 text-purple-500" />
                  <span>Unlimited portfolio items</span>
                </li>
                <li className="flex items-center">
                  <Check className="mr-2 h-4 w-4 text-purple-500" />
                  <span>Unlimited clients</span>
                </li>
                <li className="flex items-center">
                  <Check className="mr-2 h-4 w-4 text-purple-500" />
                  <span>Unlimited invoices</span>
                </li>
                <li className="flex items-center">
                  <Check className="mr-2 h-4 w-4 text-purple-500" />
                  <span>Priority support</span>
                </li>
                <li className="flex items-center">
                  <Check className="mr-2 h-4 w-4 text-purple-500" />
                  <span>Advanced analytics</span>
                </li>
                <li className="flex items-center">
                  <Check className="mr-2 h-4 w-4 text-purple-500" />
                  <span>Custom branding</span>
                </li>
              </ul>
            </CardContent>
            <CardFooter>
              <Button
                asChild
                className="w-full bg-blue-500 hover:bg-purple-600"
              >
                <Link href="/signup">Sign Up Now</Link>
              </Button>
            </CardFooter>
          </Card>
        </div>
      </div>
    </section>
  );
}
